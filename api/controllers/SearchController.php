<?php
namespace api\controllers;
use Yii;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use api\models\Frontuser;
use console\models\Maxtrainduration;
use yii\db\Query;

class SearchController extends Controller {
    private $_maxDurationBetweenCity = null;
    private $clientCityMap = [
        '100010000' => '1' ,
        '2300010000' => '14' ,
        '1200010000' => '16' ,
        '800010000' => '9' ,
        '900010000' => '6' ,
        '1300010000' => '17' ,
        '1900010000' => '23' ,
        '300110000' => '8' ,
        '1100010000' => '15' ,
        '600010000' => '10' ,
        '1500010000' => '22' ,
        '1400020000' => '11' ,
        '3000010000' => '25' ,
        '2400010000' => '21' ,
        '700010000' => '12' ,
        '1400010000' => '19' ,
        '200010000' => '2' ,
        '1300020000' => '18' ,
        '300210000' => '5' ,
        '1800010000' => '20' ,
        '2100010000' => '24' ,
        '500010000' => '3' ,
        '400010000' => '7' ,
        '1000010000' => '4' ,
        '2000010000' => '13' , 
    ];
    private $_trainCachePre = 'trainTransfer_';
    private $typeMap = [
        '1' => 'default',
        '2' => 'whole',
        '3' => 'onTrain',
        '4' => 'transferSeconds',
    ];
    public function actionTrain(){
        $request = Yii::$app->request;
        if($request->isPost){
            $mem = Yii::$app->memcache;
            $redis = Yii::$app->rediscache;
            $post = $request->post();
            if(empty($post['from']) ||
               empty($post['to'])   ||
               empty($post['type']) ||
               empty($post['page']) ||
               empty($post['counts'])){
                    throw new ForbiddenHttpException('POST data error' ,'409'); 
               }else{
                    $clientIds = array_keys($this->clientCityMap);
                    if(!in_array($post['from'] , $clientIds) || !in_array($post['to'] , $clientIds)){
                        throw new ForbiddenHttpException('cityid is wrong' ,'410'); 
                    }else{
                        $post['from'] = $this->clientCityMap[$post['from']];
                        $post['to']   = $this->clientCityMap[$post['to']];
                    }
                    if(!in_array($post['type'] , ['1' , '2' , '3' ,'4'])){
                        throw new ForbiddenHttpException('typeid is wrong' ,'411'); 
                    }
                    $post['page'] = (int)$post['page'];
                    $post['counts'] = (int)$post['counts'];
                    if($post['page'] > 9 || $post['page'] < 0 || $post['counts'] != 20){
                        throw new ForbiddenHttpException('counts or page is wrong' ,'412'); 
                    }
                    $key = $this->_trainCachePre.$post['from'].'_'.$post['to'].'_'.$this->typeMap[$post['type']]; 
                    if($mem->exists($key)){
                        $allData = $mem->get($key);
                        return $this->_getPageData($allData , $post['page'] , $post['counts']);
                    }else if($redis->exists($key)){
                        $allData = $redis->get($key);
                        return $this->_getPageData($allData , $post['page'] , $post['counts']);
                    }else{
                        $allData = $this->_getDataFromDb($post['from'] , $post['to'] , $this->typeMap[$post['type']]);
                        return $this->_getPageData($allData , $post['page'] , $post['counts']);
                    }
               }
        }else{
            throw new ForbiddenHttpException('Only support POST HTTP verb' ,'403'); 
        } 
    } 
    private function _getPageData($data , $page , $count){
        $reData['code'] = 200;
        $reData['message'] = 'OK';
        $reData['data'] = array_slice($data , $page*$count , $count);
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
    private function _filterTrainData( $allData ){
        if(empty($allData)){
            return;
        } 
        $re = [];
        foreach($allData as $d){
            if( Yii::$app->params['shortestTransferTime']  < $d['transferSeconds'] &&
                Yii::$app->params['longestTransferTime']   > $d['transferSeconds'] 
             ){ 
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
