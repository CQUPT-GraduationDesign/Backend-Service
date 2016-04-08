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
use console\models\Transfertrainline;
use api\models\Frontuser;

/**
 * generate the line for applications
 *
 * */
class LinegenController extends Controller {
    private    $formatString = ['天' , '小时' ,'分'];
    private    $factors = [ 86400 , 3600 , 60];
    private    $_maxDurationBetweenCity = null;
    /**
     * generate train transfer lines . useage: ./yii linegen/train fromcityid 
     *  
     * */
    public function actionTrain($cityid = null){
        ini_set('memory_limit', '-1');
        $destCities = Citys::find()->all();
        $fromCity = Citys::findOne(['id' => $cityid]);
        if(empty($fromCity)){
            echo 'cityid params error';
            die();
        }
       foreach($destCities as $destCity){ 
            if($destCity->id < 10){
                continue;
            }
            if($destCity->id === $fromCity->id){
                continue;
            }
            $nums = 0;
            $this->_maxDurationBetweenCity = Maxtrainduration::findOne(['fromcityid' => $fromCity->id , 'tocityid' => $destCity->id]);
            if(!empty($this->_maxDurationBetweenCity)){
                echo $fromCity->id.' ---->直达 '.$destCity->id.' 最大时间为: '.($this->_maxDurationBetweenCity->maxduration/3600).' 小时'."\n";
            }else{
                echo 'Begin : '.$fromCity->id.' -----> '.$destCity->id."\n";
            }    
            $r = $this->_calTrainLines($fromCity , $destCity);
            foreach($r as $d){
                $isSaved = $this->_saveTrainToDb($d);
                if($isSaved === true){
                    echo ++$nums.' succeed '.$fromCity->id.'  -->  '.$destCity->id."\n";
                }else{
                    var_dump($isSaved);
                }
            }
            unset($r);
       }
    }
    public function actionTest(){
        var_dump(Frontuser::findOne(['username' => true]));
    }
    private function _saveTrainToDb($data){
        if(empty($data)){
            return;
        } 
        $line = new Transfertrainline();
        $line->fromcityid = $data['dataInfo']['fromcityid'];
        $line->tocityid   = $data['dataInfo']['tocityid'];
        $line->fromcityname = $data['dataInfo']['fromcityname'];
        $line->tocityname   = $data['dataInfo']['tocityname'];
        $line->startData    = json_encode($data['stationData']['start']);
        $line->middleData   = json_encode($data['stationData']['middle']);
        $line->transferSeconds = $data['ext']['order']['transferSeconds'];
        $line->onTrainDuration = $data['ext']['order']['onTrainDuration'];
        $line->wholeDuration = $data['ext']['order']['wholeDuration'];
        if($line->save()){
            return true;
        }else{
            return $line->getErrors();
        }
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
        if(Yii::$app->params['shortestTransferTime'] < ($toStartTime - $fromEndTime) ){
            $extArray = []; 
            $extArray['transferSeconds'] =  $toStartTime - $fromEndTime ;
            $extArray['onTrainDuration'] = $this->_getTime($from['duration']) + $this->_getTime($to['duration']);
            $extArray['wholeDuration']   = $extArray['transferSeconds'] + $extArray['onTrainDuration'];
             return $extArray;
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
        if(empty($string)){
            return false;
        } 
        for( ; $i < 3 ; $i++){
            $explodeArr = explode($this->formatString[$i] , $string); 
            if(count($explodeArr) === 2){
                $re += ((int)$explodeArr[0]) * $this->factors[$i]; 
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
