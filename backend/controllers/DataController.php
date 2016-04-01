<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\models\Trainstations;
use backend\models\Planestations;
use backend\models\Citys;
use backend\models\Trainstationforcity;
use backend\models\Planestationforcity;
use yii\data\Pagination;
use yii\db\Query;
/**
 * data controller for show and handle data request
 * */
class DataController extends BackendabstractController {
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            'access' => [
                'class'  => AccessControl::className(),
                'rules' =>[   
                    [
                       'allow' => true,
                       'actions' => ['addplaneforcity', 'addtrainforcity'  ,'updatecitys','train' , 'plane' , 'citys'],
                       'roles' => ['@'],
                    ], 
                ],
    
            ],
        ];
    }
    public function actionTrain(){
        $rows = $this->_getTrainData();
        $this->render('train' , [
                 'rows' => $rows,
        ]); 
    }
    private function _getTrainData(){
        $mem = Yii::$app->memcache;
        if($mem->exists('trainStationsCache')){
            $rows = json_decode($mem->get('trainStationsCache') , true); 
        }else{
            $query = new Query();
            $query->select('*')->from('trainstations');
            $rows = $query->all();
            $value = json_encode($rows);
            $mem->set('trainStationsCache' , $value);
        }
        return $rows;
    }
    public function actionPlane(){
        $rows = $this->_getPlaneData();
        $this->render('plane' , ['rows' => $rows]);
    }
    private function _getPlaneData(){
        $mem = Yii::$app->memcache;
        if($mem->exists('planeStationsCache')){
            $rows = json_decode($mem->get('planeStationsCache') , true); 
        }else{
            $query = new Query();
            $query->select('*')->from('planestations');
            $rows = $query->all();
            $value = json_encode($rows);
            $mem->set('planeStationsCache' , $value);
        }
        return $rows; 
    }
    public function actionCitys(){
        $query = new Query();
        $query->select('*')->from('citys');
        $rows = $query->all();
        $this->render('citys' , ['rows' => $rows]);
    }
    public function actionUpdatecitys(){
        $request = Yii::$app->request;
        $selectedPlanes = [];
        $selectedTrains = [];
        $id = $request->get('id');
        $city = Citys::findOne(['id' => $id]); 
        if(empty($city)){
           $this->redirect('index/index'); 
        }
        foreach($city->planestationforcities as $pc){
            $selectedPlanes[] = Planestations::findOne(['id' => $pc->planestationid]);
        }
        foreach($city->trainstationforcities as $tc){
            $selectedTrains[] = Trainstations::findOne(['id' => $tc->trainstationid]);
        }
        $planeRows = $this->_getPlaneData();
        $trainRows = $this->_getTrainData();
        $mem = Yii::$app->memcache;
        if($mem->exists('sugTrainCache-'.$city->id) && $mem->exists('sugPlaneCache-'.$city->id)){
            $trainSug = json_decode($mem->get('sugTrainCache-'.$city->id) , true); 
            $planeSug = json_decode($mem->get('sugPlaneCache-'.$city->id) , true); 
        }else{
            $planeSug =  $this->_getSug($city->name , '机场');
            $trainSug =  $this->_getSug($city->name , '火车站');
            $mem->set('sugTrainCache-'.$city->id , json_encode($trainSug));
            $mem->set('sugPlaneCache-'.$city->id , json_encode($planeSug));
        }
        $this->render('updatecitys' , [
            'planeRows' => $planeRows,
            'trainRows' => $trainRows,
            'city'      => $city,
            'selectedTrains' => $selectedTrains,
            'selectedPlanes'  => $selectedPlanes,
            'trainSug'  => $trainSug,
            'planeSug'  => $planeSug,
            
        ]);
    }
    public function actionAddtrainforcity(){
        $request = Yii::$app->request;
        $trains = [];
        $returnData = [];
        $post = $request->post();
        $city = Citys::findOne(['id' => $post['cityid']]);
        if(empty($city)){
            throw new \yii\web\NotAcceptableHttpException();
        }
        $trainIds = $post['data'];
        foreach($trainIds as $t){
            $tr = Trainstations::findOne(['id' => $t]); 
            if(empty($tr)){
                throw new \yii\web\NotAcceptableHttpException();
            }
            $trains[] = $tr; 
        }
        foreach($trains as $t){
            $re = [];
            $train_city = new Trainstationforcity;          
            $train_city->cityid = $city->id;
            $train_city->trainstationid = $t->id;
            if(!$train_city->save()){
                throw new \yii\web\ServerErrorHttpException(); 
            }
            $re['name'] = $t->name; 
            $re['code'] = $t->code;
            $returnData[] = $re;
        }
        $trainNum = count($returnData);
        $city->trainstationnum += $trainNum;
        if(!$city->save()){
             throw new \yii\web\ServerErrorHttpException(); 
        }
        return json_encode($returnData);
    }
    public function actionAddplaneforcity(){
        $request = Yii::$app->request;
        $planes = [];
        $returnData = [];
        $post = $request->post();
        $city = Citys::findOne(['id' => $post['cityid']]);
        if(empty($city)){
            throw new \yii\web\NotAcceptableHttpException();
        }
        $planeIds = $post['data'];
        foreach($planeIds as $p){
            $pl = Planestations::findOne(['id' => $p]); 
            if(empty($pl)){
                throw new \yii\web\NotAcceptableHttpException();
            }
            $planes[] = $pl; 
        }
        foreach($planes as $p){
            $re = [];
            $plane_city = new Planestationforcity;          
            $plane_city->cityid = $city->id;
            $plane_city->planestationid = $p->id;
            if(!$plane_city->save()){
                throw new \yii\web\ServerErrorHttpException(); 
            }
            $re['name'] = $p->name; 
            $re['code'] = $p->code;
            $returnData[] = $re;
        }
        $trainNum = count($returnData);
        $city->planestationnum += $trainNum;
        if(!$city->save()){
             throw new \yii\web\ServerErrorHttpException(); 
         }
        return json_encode($returnData);
    }
    private function _getSug($city = '' , $type = '火车站'){
        $ch = curl_init(); 
       $re = [];
       $url = 'http://api.map.baidu.com/place/v2/search?q='.$type.'&region='.$city.'&output=json&ak=e6G3gcO5YnONKrrt1LZKLP6K&page_size=20&scope=1&city_limit=true&tag='.$type;
       curl_setopt($ch,CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_HEADER, true);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       $response = curl_exec($ch);
       if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $headerSize);
            $body = json_decode(substr($response, $headerSize) , true);
            foreach( $body['results'] as $b){
                $r = [];
                $r['name'] = $b['name'];
                $r['address'] = isset($b['address']) ? $b['address']:'no data';
                $re[] = $r;
            } 
            return $re;
       }else{
            return [];
       }
    }
}
