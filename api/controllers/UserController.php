<?php
namespace api\controllers;
use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use api\models\Frontuser;
/**
 *
 * User for client create(注册) and login 
 * */
class UserController extends ActiveController {
    public $modelClass = 'api\models\Frontuser';
    /**
     * Active Controller suppouted methods
     * index: list resources page by page;
     * view: return the details of a specified resource;
     * create: create a new resource;
     * update: update an existing resource;
     * delete: delete the specified resource;
     * options: return the supported HTTP methods
     *
     * */
    public function actions(){
        $actions = parent::actions();
        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['index'], $actions['views'], $actions['update']);
        // customize the data provider preparation with the "prepareDataProvider()" method
        // $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }
    public function actionRegister(){
        $request = Yii::$app->request;
        if($request->isPost){
            $newUser = new Frontuser();
            $newUser->attributes = $request->post();
            if($newUser->save()){
                return ['code'=>200 , 'message' => '注册成功' , 'access_token' => base64_encode($newUser->username.$newUser->password)];
            }else{
                if(!empty($newUser->firstErrors)){
                    $mess = "";
                    foreach($newUser->firstErrors as $k => $v){
                        $mess.=$v;
                    }
                    return ['code'=>407 , 'message'=>$mess];
                }else{
                    return ['code'=>501 , 'message'=>'服务端错误'];
                }    
            } 
        }else{
            throw new ForbiddenHttpException('Only support POST HTTP verb' ,'403'); 
        }
    }
    /**
     * POST 
     * {'username':'' , 'password':''}
     * */      
    public function actionLogin(){
        $request = Yii::$app->request;
        if($request->isPost){
            $username = $request->post('username');
            $User = Frontuser::findOne(['username'=>$username]);
            if(empty($User)){
                return ['code'=>404 , 'message'=>'用户不存在'];
            }else{
                return ['code'=>200 , 'message' => '登录成功' , 'access_token' => base64_encode($User->username.$User->password) , 'data' => json_decode($User->ext)];
            } 
        }else{
            throw new ForbiddenHttpException('Only support POST HTTP verb' ,'403'); 
        }
    }
}
