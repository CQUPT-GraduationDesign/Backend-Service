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
        $mem = Yii::$app->memcache;
        if($mem->exists('onlineCitysCache')){
            $rows = json_decode($mem->get('onlineCitysCache') , true); 
        }else{
            $query = new Query();
            $query->select('*')->from('citys');
            $rows = $query->all();
            $value = json_encode($rows);
            $mem->set('onlineCitysCache' , $value);
        }
        $this->render('citys' , ['rows' => $rows]);
    }
    public function actionUpdatecitys(){
        $request = Yii::$app->request;
        $id = $request->get('id');
        $city = Citys::findOne(['id' => $id]); 
        if(empty($city)){
           $this->redirect('index/index'); 
        }
        var_dump($city->planestationforcities);
        die();
        $planeRows = $this->_getPlaneData();
        $trainRows = $this->_getTrainData();
        $this->render('updatecitys' , [
            'planeRows' => $planeRows,
            'trainRows' => $trainRows,
            'city'      => $city,
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
        return json_encode($returnData);
    }
}
