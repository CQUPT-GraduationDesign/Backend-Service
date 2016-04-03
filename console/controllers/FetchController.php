<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use console\models\Trainstations;
use console\models\Planestations;
use console\models\Citys;
use console\models\Frontuser;
use console\models\Trainlinesout;
use console\models\Trainlinesin;
use linslin\yii2\curl;
use yii\db\Query;

class FetchController extends Controller {
    /**
     * get train data useag : ./yii fetch/trainin cityid
     * */
    public function actionTrainin($cityid = null){
        $fetchTime  = '2016-04-10';
        if(empty($cityid)){
            echo "city input is null . \n";
            return 1;
        }
        $query = new Query();   
        $query->select('*')->where('id = '.$cityid)->from('citys');
        $city = $query->all();
        if(empty($city)){
            echo "cityid is wrong \n";
            return 2;
        }
        $trainList = [];
        $city = Citys::findOne(['id'=>$city[0]['id']]); 
        $trainData  = $this->_getTrainData();
        echo "Data Ready finished \n";
        $savedNum = 0;
        $dest = $city->name; 
        foreach($trainData as $fromStation){
                $start = $fromStation['name']; 
                $url = 'http://apis.baidu.com/qunar/qunar_train_service/s2ssearch?version=1.0&from='.$start.'&to='.$dest.'&date='.$fetchTime;
                $data = $this->_trainGet($url);
                if($data == false){
                    continue;
                }else{
                    foreach( $data as $d){
                        $line  =  new Trainlinesin(); 
                        $isSaved = $this->_saveTrainLine($line , $d, $city->name , $city->id, $fromStation['id']);
                        // last param(trainid) build  the IN-graph 
                        if($isSaved === true){
                            echo ++$savedNum.' saved succeed from'.$d['from'].'to :'.$d['to'].'train No :'.$d['trainNo']."\n";
                        }else{
                           echo $isSaved."\n"; 
                        }
                    }
                }
           }
    }
    /**
     * get train data useag : ./yii fetch/trainout cityid
     * */
    public function actionTrainout($cityid = null){
        $fetchTime  = '2016-04-10';
        if(empty($cityid)){
            echo "city input is null . \n";
            return 1;
        }
        $query = new Query();   
        $query->select('*')->where('id = '.$cityid)->from('citys');
        $city = $query->all();
        if(empty($city)){
            echo "cityid is wrong \n";
            return 2;
        }
        $trainList = [];
        $city = Citys::findOne(['id'=>$city[0]['id']]); 
        $trainData  = $this->_getTrainData();
        echo "Data Ready finished \n";
        $savedNum = 0;
        $start = $city->name; 
        foreach($trainData as $dstStation){
                $dest = $dstStation['name']; 
                $url = 'http://apis.baidu.com/qunar/qunar_train_service/s2ssearch?version=1.0&from='.$start.'&to='.$dest.'&date='.$fetchTime;
                $data = $this->_trainGet($url);
                if($data == false){
                    continue;
                }else{
                    foreach( $data as $d){
                        $line  =  new Trainlinesout(); 
                        $isSaved = $this->_saveTrainLine($line , $d, $city->name , $city->id, $dstStation['id']);
                        // last param(trainid) build  the OUT-graph 
                        if($isSaved === true){
                            echo ++$savedNum.' saved succeed from'.$d['from'].'to :'.$d['to'].'train No :'.$d['trainNo']."\n";
                        }else{
                           echo $isSaved."\n"; 
                        }
                    }
                }
           }
    }
    private function _saveTrainLine($line = null , $data = null , $cityName = null 
                                    , $cityId = null , $toTrainId = null){
        $line->cityid = $cityId;
        $line->trainid = $toTrainId;
        $line->cityname = $cityName;
        $line->fromtrain = $data['from'];
        $line->totrain = $data['to'];
        $line->traintype = $data['trainType'];
        $line->trainno = $data['trainNo'];
        $line->starttime = $data['startTime'];
        $line->endtime = $data['endTime'];
        $line->duration= $data['duration'];
        $line->rawData = json_encode($data);
        if($line->save()){
            return true;
        }else{
            $errors = $line->getErrors();
            $err = '';
            foreach( $errors as $key=>$val){
               $e = '';
               foreach($val as $v){
                    $e.=$v;
               }
               $err.=$key.' : '.$e;
            }
            return $err;
        }
    }
    private function _trainGet($url){
        $curl = new curl\Curl();
        $header = ['apikey: da83e93a41055e9f9b7f0ffad2655ad4'];
        $response = $curl->setOption(CURLOPT_HTTPHEADER,
                    $header)->get($url);
        $response = json_decode($response , true);
        if($response['ret'] == false){
            return false;
        }
        return $response['data']['trainList'];
    }
    private function _getTrainData(){
       $query = new Query();
        $query->select('code , id , name')->from('trainstations');
        $rows = $query->all();
        return $rows;
    }
    public function actionPlane(){
        
    }
    public function actionTest(){
       $user = new Frontuser(); 
       $user->username = 'lk1';
       $user->password = '123';
       $user->ext = '123';
       var_dump($user->validate());
       var_dump($user->getErrors());
    }

}
