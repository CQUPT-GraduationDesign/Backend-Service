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
 * fetch data show controller for show and handle data request
 * */
class FetchController extends BackendabstractController {
    public function actionTrainin(){
        $query = new Query(); 
        $query->select('*')->from('trainlinesin')->limit(20);
        $data = $query->all();
        $this->render('trainin',['data' => $data]);
    }
    public function actionTraininapi(){
        echo 111;
    }


}
