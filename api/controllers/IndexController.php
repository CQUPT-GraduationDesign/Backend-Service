<?php
namespace api\controllers;
use Yii;
use yii\web\Controller;

class IndexController extends Controller {
    public function actionError(){
        $exception = Yii::$app->errorHandler->exception;
        var_dump($exception);
    }
} 
