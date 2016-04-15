<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\models\Trainstations;
use backend\models\Planestations;
use backend\models\Citys;
use backend\models\Trainstationforcity;
use backend\models\Planestationforcity;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\BadRequestHttpException;
use console\models\Maxtrainduration;
/**
 * */
class OnlineController extends BackendabstractController {
    private $_maxDurationBetweenCity = null;
    public function actionCitys(){
        $query = new Query();
        $query->select('*')->from('citys');
        $rows = $query->all();
        $this->render('citys' , ['rows' => $rows]);
    }
    public function actionTrainlines(){
        $get = Yii::$app->request->get(); 
        $this->render('trainlines');
    }
    public function  actionTrainlinesapi(){
        $get = Yii::$app->request->get(); 
        if(Yii::$app->request->isAjax){
            $data = $this->_getDataFromDb($get['from'] , $get['to'] , 'default');
            $re = [];
            $re['draw'] = $get['draw'];
            $re['recordsTotal'] = count($data);
            $data = array_slice($data , $get['start']  , $get['length']);
            $dealData = [];
            foreach($data as $d){
                $temp['fromname']  = $d['fromcityname'];
                $temp['toname'] = $d['tocityname'];
                $start = $d['startData'];
                $middle = $d['middleData'];
                $temp['middlename'] = $start['to'];
                $temp['startTime_start'] = $start['startTime'];
                $temp['endTime_start'] = $start['endTime'];
                $temp['trainno_start'] = $start['trainno'];
                $temp['startTime_middle'] = $middle['startTime'];
                $temp['endTime_middle'] = $middle['endTime'];
                $temp['trainno_middle'] = $middle['trainno'];
                $dealData[] = $temp;
                $temp = [];
            }
            $re['recordsFiltered'] = $re['recordsTotal'];
            $re['data'] = $dealData;
            return json_encode($re);
        }else{
            throw new BadRequestHttpException('only ajax' , 406);
        }
        var_dump($get);
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

}
