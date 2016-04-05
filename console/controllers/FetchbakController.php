<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use console\models\Trainstations;
use console\models\Planestations;
use console\models\Citys;
use console\models\Frontuser;
use console\models\Trainlines;
use console\models\Planelinein;
use linslin\yii2\curl;
use yii\db\Query;

class FetchbakController extends Controller {
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
                        $isSaved = $this->_saveTrainLine($d, $city->name , $city->id, $dstStation['id']);
                        if($isSaved === true){
                            echo ++$savedNum.' saved succeed from'.$d['from'].'to :'.$d['to'].'train No :'.$d['trainNo']."\n";
                        }else{
                           echo $isSaved."\n"; 
                        }
                    }
                }
           }
    }
    private function _saveTrainLine($data = null , $cityName = null 
                                    , $cityId = null , $toTrainId = null){
        $line  =  new Trainlines(); 
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
    /**
     * fetch the plane data . useage: ./yii fetch/planein cityid
     * */
    public function actionPlanein($cityid = null){
        $time = '20160406';
        $nums = 0;
        if(empty($cityid)){
            echo "cityid is null";
            exit;
        } 
        $city = Citys::findOne(['id' => $cityid]);
        $planeOfCity = $city->getPlanes();
        $planeData = $this->_getPlaneData();
        foreach($planeOfCity  as $pc){
                $dest = $pc->code;  
            foreach($planeData as $pd){
                $from = $pd['code']; 
                $data = $this->_getPlaneLine($from , $dest , $time);
                if(isset($data['page'])){
                    continue;
                }else{
                    foreach($data['FlightStatusList']['flightSocList'] as $d){
                        $line = new Planelinein(); 
                        $isSaved = $this->_savePlaneLine($d , $line , $city->id); 
                        if($isSaved === true){
                            echo ++$nums.' succeed'.'from '.$d['depportName'].' to '.$d['arrportName'].' planeNo '.$d['flightNo']."\n";
                        }else{
                            echo $isSaved."\n"; 
                        }  
                    }
                }
           }
        } 
    }
    private function _savePlaneLine( $data = null , $line = null , $cityid = null){
        if(empty($data) || empty($line) || empty($cityid)){
            echo 'save Plane data parms error';
            exit(1);
        }
        $line->cityid = $cityid; 
        $line->planeno = $data['flightNo'];
        $line->fromcode = $data['depport'];
        $line->tocode = $data['arrport'];
        $line->fromname = $data['depportName'];
        $line->toname = $data['arrportName'];
        $line->starttime = $data['schdepTime'];
        $line->endtime = $data['schearrTime'];
        $line->rawdata = json_encode($data);
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
    private function _getPlaneData(){
        $query = new Query();
        $query->select('code , id , name , city')->from('planestations');
        $rows = $query->all();
        return $rows;
    }
    private function _getPlaneLine($from = null , $dest = null , $time = null){
        if(empty($from) || empty($dest) || empty($time)){
            echo "getPlaneLine parms error \n";
            exit(2);
        }
        $ch = curl_init();
        $url  = 'http://m.csair.com/mbpwas.shtml?lang=zh&_=14583991'.rand(29123,99921);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $cookie = "BIGipServerpool_m.csair.com_".rand(123,245).".16.47.9-11=3875449024.20480.0000; WT-FPC=id=113.".rand(101 , 250).".152.54-3465215408.30507502:lv=145839908".rand(1234 , 9898).":ss=145839908".rand(2222,8888).":fs=145839908".rand(1111 , 9999).":pn=1:vn=1; JSESSIONID=66p6cy283jxu8soett30fjfy";
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "User-Agent: Mozilla/5.0 (Linux; U; Android 4.4.4; zh-cn; MI 4LTE Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/42.0.0.0 Mobile Safari/537.36 XiaoMi/MiuiBrowser/2.1.1",
            "Origin: http://m.csair.com",
            "Cookie: ".$cookie,
            "Content-Type: application/x-www-form-urlencoded",
            "Referer: http://m.csair.com/touch/com.csair.mbp.index/index.html",
         ]
       );
        $body = [
               "url" => "CSMBP/data/order/queryFlightByAirport.do?type=MOBILE&type=MOBILE&token=E0xywTTmPMVVPd5B8u4cPvBMW2B4ZKPwpZ194hyuI%2FoDWG35pqOxAw%3D%3D&lang=zh",
               "pagebase" => "http://m.csair.com",
               "page" => "{\"page\":{\"ARRAIRPORT\":\"".$dest."\",\"DEPAIRPORT\":\"".$from."\",\"DATE\":\"".$time."\"}}",
               ];
        $body = http_build_query($body);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $resp = curl_exec($ch);
        if(!$resp) {
            return false;
        } else {
            return json_decode($resp , true);
        }
        curl_close($ch);
    }
}
