<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use console\models\Trainstations;
use console\models\Planestations;
use console\models\Citys;
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
     * generate the longest duration time between the configured(onlined) citys for next data gen
     *
     * */
    public function actionGenlongtime(){
    
    
    }
}
