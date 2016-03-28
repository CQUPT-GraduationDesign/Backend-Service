<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * index controller
 * */
class IndexController extends BackendabstractController {
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class'  => AccessControl::className(),
                'rules' =>[   
                    [
                       'allow' => true,
                       'actions' => ['index'],
                       'roles' => ['@'],
                    ], 
                    [
                       'allow' => true,
                       'actions' => ['error'],
                    ], 
                ],
    
            ],
        ];
    }
    
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionError(){
        $exception = Yii::$app->errorHandler->exception;
        if($exception !== null) {
            return $this->renderPartial('error', ['exception' => $exception]);
        }else{
            $this->redirect(['index/index']);
        }
    }
}
