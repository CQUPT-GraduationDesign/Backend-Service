<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\models\Trainstations;
use backend\models\Planestations;
use yii\data\Pagination;
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
                       'actions' => ['train' , 'plane' , 'citys'],
                       'roles' => ['@'],
                    ], 
                ],
    
            ],
        ];
    }
    public function actionTrain(){
       $models = Trainstations::find()->all();
       $this->render('train' , [
                 'models' => $models,
       ]); 
    }
    public function actionPlane(){
        $data = Planestations::find()->all();
        $this->render('plane' , ['models' => $data]);
    }
}
