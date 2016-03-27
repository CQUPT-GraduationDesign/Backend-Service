<?php
namespace api\controllers;
use Yii;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;

class ResController extends Controller {

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                   'allow' => true,
                   'actions' => ['list'],
                   'roles' => ['@'],
                   'denyCallback' => function ($rule, $action){
                        throw new \Exception('登录后访问','407');
                    }
                ],
            ],
        ];
       return $behaviors;
    }
    public function actionList(){
        return ['data'=>['after authorization']];
    }


}