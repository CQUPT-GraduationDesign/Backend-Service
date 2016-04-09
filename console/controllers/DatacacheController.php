<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use console\models\Trainstations;
use console\models\Planestations;
use console\models\Citys;
use console\models\Trainlinesout;
use console\models\Trainlinesin;
use console\models\Planelinein;
use console\models\Planelineout;
use console\models\Maxtrainduration;
use console\models\Transfertrainline;
use api\models\Frontuser;
use yii\db\Query;
/**
 * Cache transferData in cahche instance (Redis , memcached)
 * */
class DatacacheController extends Controller {
    /**
     * cache names like that : trainTransfer_fromcityid_tocityid_default
     * */
    private $_trainCachePre = 'trainTransfer_';

    private $_maxDurationBetweenCity = null;
    
    private $_mem = null;
    private $_redis = null;
    /**
     * cache train transfer data useage : ./yii datacache/train
     * */
    public function actionTrain($cityid = null){
        ini_set('memory_limit', '-1');
        $orderConfig = [
           'default'  => 'wholeDuration , onTrainDuration , transferSeconds',
           'whole'    => 'wholeDuration',
           'onTrain'  => 'onTrainDuration',
           'transfer' => 'transferSeconds',
        ];
        $this->_mem = Yii::$app->memcache;
        $this->_redis = Yii::$app->rediscache;
        $fromCity =   Citys::findOne(['id' => $cityid]);
        if(empty($fromCity)){
            echo 'cityid is wrong';
            exit(2);
        }
        $destCities = Citys::find()->all();
        foreach($destCities as $destCity){
            if($fromCity->id == $destCity->id){
                continue;
            }
            $this->_maxDurationBetweenCity = Maxtrainduration::findOne(['fromcityid' => $fromCity->id , 'tocityid' => $destCity->id]);
            foreach($orderConfig as $key => $order){
                $allData = $this->_getTrainData($fromCity , $destCity , $order);         
                $filteredData = $this->_filterTrainData($allData);
                if(empty($filteredData)){
                    $filteredData = $allData;
                }
                if(empty($filteredData)){
                    echo "data is null\n";
                    continue;
                }
                $cachedData = array_slice($filteredData , 0 , 200);
                $key = $this->_trainCachePre.$fromCity->id.'_'.$destCity->id.'_'.$key; 
                if(!$this->_mem->exists($key)){
                    if($this->_mem->set($key , $cachedData) === true){
                        echo $fromCity->id.' ------> '.$destCity->id.' mem succeed '.$key."\n"; 
                    }else{
                        echo $fromCity->id.' ------> '.$destCity->id.' mem failed'.$key."\n"; 
                    }
                }else{
                    echo $fromCity->id.' ------> '.$destCity->id.' mem existed'.$key."\n"; 
                }
                if(!$this->_redis->exists($key)){
                    if($this->_redis->set($key , $cachedData) === true){
                        echo $fromCity->id.' ------> '.$destCity->id.' redis succeed '.$key."\n"; 
                    }else{
                        echo $fromCity->id.' ------> '.$destCity->id.' redis failed'.$key."\n"; 
                    }
                }else{
                    echo $fromCity->id.' ------> '.$destCity->id.' redis existed'.$key."\n"; 
                }
                unset($allData);
                unset($cachedData);
            }
        }
    }   
    private function _getTrainData($from , $dest , $order = ''){
        if(empty($from) || empty($dest)){
            return;
        }
        $query = new Query();
        $query->select('*')->where('fromcityid = '.$from->id.' and tocityid = '.$dest->id)->orderBy($order)->from('transfertrainline');
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
