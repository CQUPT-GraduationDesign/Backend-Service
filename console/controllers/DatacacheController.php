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
     * cache names like that : trainTransfer_fromcityid_tocityid
     * */
    private $_trainTransferRedisKeyPre = 'trainTransfer_';
    /**
     * cache names like that : trainTransfer_fromcityid_tocityid
     * */
    private $_trainTransferMemKeyPre = 'trainTransfer_';

    private $_maxDurationBetweenCity = null;

    /**
     * cache train transfer data
     * */
    public function actionTrain(){
        $fromCity = Citys::findOne(['id' => 8]);
        $destCities = Citys::find()->all();
        foreach($destCities as $destCity){
            $this->_maxDurationBetweenCity = Maxtrainduration::findOne(['fromcityid' => $fromCity->id , 'tocityid' => $destCity->id]);
            $allData = $this->_getTrainData($fromCity , $destCity);         
            $filteredData = $this->_filterTrainData($allData);
            unset($allData);
            if(empty($filteredData)){
                var_dump(0);
                continue;
            }
            $cachedData = array_slice($filteredData , 0 , 200);
            var_dump(mb_strlen(json_encode($cachedData))/(1024));
        }
    }   
    private function _getTrainData($from , $dest){
        if(empty($from) || empty($dest)){
            return;
        }
        $query = new Query();
        $query->select('*')->where('fromcityid = '.$from->id.' and tocityid = '.$dest->id)->orderBy('wholeDuration , onTrainDuration , transferSeconds')->from('transfertrainline');
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
