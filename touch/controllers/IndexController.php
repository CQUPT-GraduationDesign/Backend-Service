<?php
namespace touch\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use console\models\Maxtrainduration;
use yii\db\Query;
/**
 * touch Index  controller
 */
class IndexController extends Controller{
    private $_cityConfig = [
                     "北京",
                     "上海",
                     "天津",
                     "西安",
                     "深圳",
                     "重庆",
                     "武汉",
                     "广州",
                     "成都",
                     "杭州",
                     "济南",
                     "南京",
                     "郑州",
                     "长春",
                     "哈尔滨",
                     "长沙",
                     "大连",
                     "沈阳",
                     "青岛",
                     "石家庄",
                     "南昌",
                     "合肥",
                     "福州",
                     "太原",
                     "兰州",
                    ]; 
    private $_trainCachePre = 'trainTransfer_';
    private $_maxDurationBetweenCity = null;
    private $typeMap = [
        '1' => 'default',
        '2' => 'whole',
        '3' => 'onTrain',
        '4' => 'transfer',
    ];
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionSearch(){
        $request = Yii::$app->request;
        $get = $request->get();
        $ids = [];
        $pageContent = '';
        if(!empty($get['s']) && !empty($get['d'])){
            $ids = $this->_nameToId($get['s'] , $get['d']);
        }else{
            throw new BadRequestHttpException();          
        } 
        if(empty($ids)){
            throw new BadRequestHttpException();          
        }
        $mem = Yii::$app->memcache;
        $redis = Yii::$app->rediscache;
        foreach($this->typeMap as $typeNum => $type){
            $key = $this->_trainCachePre.$ids['s'].'_'.$ids['d'].'_'.$type; 
            if($mem->exists($key)){
                $allData = $mem->get($key);
                $pageContent[$typeNum] = $this->_getPageData($allData , 0 , 20);
            }else if($redis->exists($key)){
                $allData = $redis->get($key);
                $pageContent[$typeNum] = $this->_getPageData($allData , 0 , 20);
            }else{
                $allData = $this->_getDataFromDb($ids['s'] , $ids['d'] , $type);
                $pageContent[$typeNum] = $this->_getPageData($allData , 0 , 20);
            }
        }
        return $this->render('search' ,['pageContent' => $pageContent]);
    }
    private function _getPageData($data , $page , $count){
        $reData = [];
        if(!empty($data)){
            $reData= array_slice($data , $page*$count , $count);
        }else{
           throw new  \yii\web\NotFoundHttpException('No data' , '404');
        }
        return $reData;
    }
    private function _getDataFromDb($from , $to , $type){
        $orderConfig = [
           'default'  => 'wholeDuration , onTrainDuration , transferSeconds',
           'whole'    => 'wholeDuration',
           'onTrain'  => 'onTrainDuration',
           'transfer' => 'transferSeconds',
        ];
        $this->_maxDurationBetweenCity = Maxtrainduration::findOne(['fromcityid' => $from, 'tocityid' => $to]);
        $rawData = $this->_getTrainData($from , $to , $orderConfig[$type]);  
        $filteredData = $this->_filterTrainData($rawData);
        return $filteredData;
    }
    private function _getTrainData($from , $dest , $order = ''){
        if(empty($from) || empty($dest)){
            return;
        }
        $query = new Query();
        $query->select('*')->where('fromcityid = '.$from.' and tocityid = '.$dest)->orderBy($order)->from('transfertrainline');
        return $query->all();
    }
    /**
     * 
     * 1.过滤时间上不合适的数据
     * 2.给火车类型数据添加区分的字段
     *
     * */
    private function _filterTrainData( $allData ){
        if(empty($allData)){
            return;
        } 
        $re = [];
        foreach($allData as $d){
            if( Yii::$app->params['shortestTransferTime']  < $d['transferSeconds'] &&
                Yii::$app->params['longestTransferTime']   > $d['transferSeconds'] 
             ){ 
                 $d['startData'] = json_decode($d['startData'] , true);
                 $d['middleData'] = json_decode($d['middleData'] , true);
                 $d['startData']['type'] = 1;
                 $d['middleData']['type'] = 1;
                 if(!empty($this->_maxDurationBetweenCity) && 
                Yii::$app->params['maxDurationFactor']*$this->_maxDurationBetweenCity->maxduration > $d['wholeDuration']){
                    $re[] = $d; 
                 }else{
                    $re[] = $d;
                 }
            }
        }
        return $re;
    }
    /**
     *
     * an ugly way to get cityname to id
     * */
   private function _nameToId($s = null , $d = null){
        $start = false;
        $dest = false; 
        $i  = 1;
        foreach($this->_cityConfig as $c){
            if($s == $c){
                $start = $i;
            }
            if($d == $c){
                $dest = $i;
            }
            $i++;
            if($start != false && $dest != false){
                break;
            }
        }
        if($start === false && $dest === false){
            return false;
        }
        return ['s'=>$start , 'd' => $dest];
   }
}
