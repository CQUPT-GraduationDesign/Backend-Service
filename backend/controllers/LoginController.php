<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\BackendLoginForm;
/**
 * Login controller
 * */
class LoginController extends Controller {
    
    public function actionIndex(){
        return $this->renderPartial('index');
    }
    public function actionLogin(){
        $request = Yii::$app->request;
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new BackendLoginForm();
        $model->attributes = $request->post();
        if($model->login()){
            return $this->goBack();
        }else{
            return $this->renderPartial('index' , ['model' => $model]);
        }
    }
    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->urlManager->createUrl('login/index'));
    }
}
