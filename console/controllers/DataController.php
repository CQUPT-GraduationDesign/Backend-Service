<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use console\models\Trainstations;
use console\models\Planestations;
use console\models\Citys;
use console\models\Maxtrainduration;
use console\models\Trainlinesout;
use console\models\Trainlinesin;
use yii\db\Query;
/**
 * Init the data config (like online city , train stations , plane stations)
 *
 *
 * */
class DataController extends Controller {
    public function actionInserttrain(){
        $nums = 0;
        $data  = file_get_contents(Yii::$app->params['trainStationsData']);
        $data = explode('@' , $data);
        unset($data[0]);
        foreach($data as $d){
            $rawData = explode('|' , $d);
            $stations = new Trainstations();
            if(count($rawData)  == 6){
                $stations->shortalphabetic = $rawData[0];
                $stations->name = $rawData[1];
                $stations->code = $rawData[2];
                $stations->alphabetic = $rawData[3];
                if($stations->save()){
                    $nums++;
                    echo $stations->id.' -> '.$stations->name.'store succeed'."\n";
                }else{
                    var_dump($stations->getErrors());
                }
            }else{
                var_dump($rawData);
            }
        }
        echo "\n\n\n".$nums;
    }
    public function actionInsertplane(){
        $nums = 0;
        $data = file_get_contents(Yii::$app->params['planeStationsData']); 
        $data = explode("\n" , $data);
        unset($data[count($data)-1]);
        $data = array_chunk($data , 5);
        foreach( $data as $d){
            $plane = new Planestations(); 
            $plane->province = $d[0];
            $plane->city = $d[1];
            $plane->code = $d[2];
            $plane->name = $d[3];
            $plane->alphabetic = $d[4];
            if($plane->save()){
                $nums++;
                echo $plane->id.'->'.$plane->name."succeed ! \n";
            }else{
                var_dump($plane->getErrors());
            }
        }
        echo "\n\n\n".$nums;
    } 
    public function actionInsertcitys(){
        $nums = 0;
        $data = require(Yii::$app->params['onlineCitysDataForRequire']); 
        foreach( $data as $d){
            $city = new Citys(); 
            $city->name = $d;
            if($city->save()){
                $nums++;
                echo $city->id.'->'.$city->name."succeed ! \n";
            }else{
                var_dump($city->getErrors());
            }
        }
        echo "\n\n\n".$nums;
    }
    /**
     * generate the longest duration time between the configured(onlined) citys for next data ge
     *
     * */
    public function actionGenlongtime(){
        $query = new Query();
        $citysFrom = Citys::find()->all();   
        $citysTo = Citys::find()->all();   
        foreach($citysFrom as $cf){
            foreach($citysTo as $ct){
                if($cf->id === $ct->id){
                    continue;
                } 
                $fromTrains = $cf->getTrains();
                $toTrains = $ct->getTrains();
                $reData = [];
                foreach( $fromTrains as $ft){
                    foreach($toTrains as $tt){
                         $query->select('id , fromtrain , totrain , duration')->where('fromtrain = "'.$ft->name.'" and totrain = "'.$tt->name.'"')->from('trainlinesin'); 
                         $durDataIn =  $query->all();
                         $query->select('id , fromtrain , totrain , duration')->where('fromtrain = "'.$ft->name.'" and totrain = "'.$tt->name.'"')->from('trainlinesout'); 
                         $durDataOut = $query->all();
                         $reData = array_merge($durDataIn , $durDataOut , $reData);
                    } 
                }
                $maxData = $this->_getMaxDuration($reData);
                if($maxData != false){
                    $isSaved = $this->_saveMaxDuration($maxData , $cf , $ct); 
                    if($isSaved === true){
                        echo $cf->name.' -----> '.$ct->name.'  max saved succeed'."\n";
                    }else{
                        var_dump($isSaved);
                    }
                }
            }
        }
    
    }
    private function _saveMaxDuration($maxData , $from , $to){
        if(empty($maxData) || empty($from) || empty($to)){
            echo "params error";
            exit(2);
        } 
        $max = new Maxtrainduration();
        $max->fromcityid = $from->id;
        $max->tocityid = $to->id;
        $max->maxduration = $maxData['maxTime'];
        $max->trainlineid = $maxData['trainline']['id'];
        $rawData = Trainlinesin::findOne(['id' => $maxData['trainline']['id'] , 'duration' => $maxData['trainline']['duration']]); 
        if(empty($rawData)){
            $rawData = Trainlinesout::findOne(['id' => $maxData['trainline']['id'] , 'duration' => $maxData['trainline']['duration']]); 
        }
        $max->trainlinerawdata = json_encode($rawData->attributes); 
        if($max->save()){
            return true;
        }else{
            return $max->getErrors();
        }
    }
    private function _getMaxDuration($durData = null){
        if(empty($durData)){
            return false;
        }
        $re['maxTime'] = 0;
        $re['trainline'] = null;
        foreach($durData as $d){
           $tempTime = $this->_getTime($d['duration']); 
           if($re['maxTime'] < $tempTime){
                $re['maxTime'] = $tempTime;
                $re['trainline'] = $d;
           }
        }
        return $re;
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
}
