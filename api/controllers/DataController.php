<?php
namespace api\controllers;
use Yii;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use api\models\Frontuser;
use yii\db\Query;

class DataController extends Controller {
    public function actionOnlinecities(){
        $query = new Query();
        $query->select('id , name')->from('citys');
        return $query->all();
    }
}
