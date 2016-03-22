<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
/**
 * index controller
 * */
class IndexController extends Controller {
    
    public function actionIndex()
    {
        var_dump(Yii::$app->user->identity);die();
        return $this->render('index');
    }
}
