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
                       'actions' => ['updatecitys','train' , 'plane' , 'citys'],
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
        $planeRows = $this->_getPlaneData();
        $trainRows = $this->_getTrainData();
        $this->render('updatecitys' , [
            'planeRows' => $planeRows,
            'trainRows' => $trainRows,
        ]);
    }
}
