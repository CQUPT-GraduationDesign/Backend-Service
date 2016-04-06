<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use console\models\Trainstations;
use console\models\Planestations;
use console\models\Citys;
use yii\db\Query;
use console\models\Trainlinesout;
use console\models\Trainlinesin;
use console\models\Planelinein;
use console\models\Planelineout;
use console\models\Maxtrainduration;
use api\models\Frontuser;

/**
 * generate the line for applications
 *
 * */
class LinegenController extends Controller {
    private $_maxDurationBetweenCity = null;
    /**
     * cache names like that : trainTransfer_fromcityid_tocityid
     * */
    private $_trainTransferRedisKeyPre = 'trainTransfer_';
    /**
     * cache names like that : trainTransfer_fromcityid_tocityid
     * */
    private $_trainTransferMemKeyPre = 'trainTransfer_';
    /**
     * generate train transfer lines . useage: ./yii linegen/train fromcityid tocityid
     *  
     * */
    public function actionTrain(){
       $fromCity = Citys::findOne(['id' => 1]); 
       $destCity = Citys::findOne(['id' => 25]); 
       $this->_maxDurationBetweenCity = Maxtrainduration::findOne(['fromcityid' => $fromCity->id , 'tocityid' => $destCity->id]);
       $r = $this->_calTrainLines($fromCity , $destCity);
       var_dump($r); 
    }
    public function actionTest(){
        var_dump(Frontuser::findOne(['username' => true]));
    }
    /**
     * @param: ( Citys )from , dest
     *
     * */
    private function _calTrainLines($from , $dest){
        $result = []; 
        $exportGraph = $this->_getTrainLineData($from->id , 'trainlinesout');
        $importGraph = $this->_getTrainLineData($dest->id , 'trainlinesin');
        foreach($exportGraph as $e){
            foreach($importGraph as $i){
                if($e['totrain'] == $i['fromtrain']){
                    if(is_array( $extArray = $this->_filterTrainData($e , $i))){
                        $re = [
                            'dataInfo' => [
                                'fromcityid' => $from->id,
                                'tocityid'   => $dest->id,
                                'fromcityname' => $from->name,
                                'tocityname'  => $dest->name,
                            ],
                            'stationData' => [
                                'start' => [
                                    'from' => $e['fromtrain'],
                                    'to' =>   $e['totrain'],
                                    'trainno' => $e['trainno'],
                                    'startTime' => $e['starttime'],
                                    'endTime'   => $e['endtime'],
                                    'duration'  => $e['duration'],
                                ],
                                'middle' => [
                                    'from'      => $i['fromtrain'],
                                    'to'        => $i['totrain'],
                                    'trainno'   => $i['trainno'],
                                    'startTime' => $i['starttime'],
                                    'endTime'   => $i['endtime'],
                                    'duration'  => $i['duration'],
                                ],
                            ],
                            'ext'    =>[
                                'order' => $extArray, 
                                ],
                        ];
                        $result[] = $re;
                    }
                }
            }
        }
        return $result;
    }
    /**
     *
     * filter valid data
     * */
    private function  _filterTrainData($from , $to){
        date_default_timezone_set('PRC');
        if(empty($from) || empty($to)){
            echo "params fatla error";
            exit(1);
        }
        $fromEndTime = strtotime($from['starttime']) + $this->_getTime($from['duration']);
        $toStartTime = strtotime($to['starttime']);
        // 中间有 2  小时用来换乘
        if($toStartTime - $fromEndTime  >= 2*3600){
            $extArray = []; 
            $extArray['transferSeconds'] =  $toStartTime - $fromEndTime ;
            $extArray['onTrainDuration'] = $this->_getTime($from['duration']) + $this->_getTime($to['duration']);
            $extArray['wholeDuration']   = $extArray['transferSeconds'] + $extArray['onTrainDuration'];
            if(!empty($max) ){
                if($extArray['onTrainDuration'] < 1.0*$this->_maxDurationBetweenCity->maxduration){
                    return $extArray;
                }else{
                    return false;
                }
            }else{
                return $extArray;
            }
        }else{
            return false;
        }
    }
    /**
     * @brief a helper function to get real duration
     * @return seconds(int)
     * */
    private function _getTime($string){
        $re = 0;
        $i  =  0;
        $formatString = ['天' , '小时' ,'分'];
        $factors = [3600*24 , 3600 , 60];
        if(empty($string)){
            return false;
        } 
        for( ; $i < 3 ; $i++){
            $explodeArr = explode($formatString[$i] , $string); 
            if(count($explodeArr) === 2){
                $re += ((int)$explodeArr[0]) * $factors[$i]; 
                $string = $explodeArr[1];
            }else{
                $string = $explodeArr[0]; 
            }
        } 
        return $re;
    }
    private function _getTrainLineData($cityId , $tableName = null){
        $query = new Query(); 
        $query->select('cityid ,cityname , trainid , fromtrain , totrain , duration ,trainno , starttime , endtime')->where('cityid = '.$cityId)->from($tableName);
        return $query->all();
    }
}
