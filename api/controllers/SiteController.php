<?php
namespace api\controllers;

use yii\web\Controller;

class SiteController extends Controller {
    public $layout = false;

    public function actionIndex(){
        return "hello api";
    }
} 
