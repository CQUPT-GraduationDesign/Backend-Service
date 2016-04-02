<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use console\models\Trainstations;
use console\models\Planestations;
use console\models\Citys;
use console\models\Frontuser;
use console\models\Trainlines;
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
    public function actionPlane(){
        var_dump($this->_getPlaneLine());
    }
    private function _getPlaneLine(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://m.csair.com/mbpwas.shtml?lang=zh&_=1458399193163');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "User-Agent: Mozilla/5.0 (Linux; U; Android 4.4.4; zh-cn; MI 4LTE Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/42.0.0.0 Mobile Safari/537.36 XiaoMi/MiuiBrowser/2.1.1",
            "Origin: http://m.csair.com",
            "Cookie: BIGipServerpool_m.csair.com_172.16.47.9-11=3875449024.20480.0000; WT-FPC=id=113.250.152.54-3465215408.30507502:lv=1458399088353:ss=1458399088353:fs=1458399088353:pn=1:vn=1; JSESSIONID=66p6cy283jxu8soett30fjfy",
            "Content-Type: application/x-www-form-urlencoded",
            "Referer: http://m.csair.com/touch/com.csair.mbp.index/index.html",
         ]
       );
        $body = [
               "url" => "CSMBP/data/order/queryFlightByAirport.do?type=MOBILE&type=MOBILE&token=E0xywTTmPMVVPd5B8u4cPvBMW2B4ZKPwpZ194hyuI%2FoDWG35pqOxAw%3D%3D&lang=zh",
               "pagebase" => "http://m.csair.com",
               "page" => "{\"page\":{\"ARRAIRPORT\":\"CTU\",\"DEPAIRPORT\":\"PEK\",\"DATE\":\"20160328\"}}",
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
