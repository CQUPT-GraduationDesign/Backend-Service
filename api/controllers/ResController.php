<?php
namespace api\controllers;
use Yii;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use api\models\Frontuser;
use api\models\Usercollect;
use api\models\Transfertrainline;

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
                   'actions' => ['addcol', 'getlist' , 'delcol'],
                   'roles' => ['@'],
                   'denyCallback' => function ($rule, $action){
                        throw new \Exception('登录后访问','407');
                    }
                ],
            ],
        ];
       return $behaviors;
    }
    public function actionGetlist(){
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity; 
            $collects = Usercollect::find(['frontuserid' => $user->uid])->where('isdeleted = 0')->all();
            $trainlinesRe = [];
            foreach($collects as $c){
                $trainlinesRe[] = $c->transferline;
            }
            return $trainlinesRe;
        }else{
            throw new ForbiddenHttpException('you are not allowed' ,'407'); 
        }
    }
    public function actionAddcol(){
        if(!Yii::$app->user->isGuest){
            $post = Yii::$app->request->post();
            $user = Yii::$app->user->identity; 
            if(empty($post['trainlineid'])){
                throw new ForbiddenHttpException('trainline id is empty' ,'413'); 
            }
            $trainline = Transfertrainline::findOne(['id' => $post['trainlineid']]);
            if(empty($trainline)){
                throw new ForbiddenHttpException('trainline id is wrong' ,'408'); 
            }
            $col = new Usercollect;
            $col->frontuserid = $user->uid;
            $col->transferlineid = $post['trainlineid'];
            $col->datetime = date('Y-m-d H:i:s' , time());
            $col->save();
            return ['code'=>200 , 'message' => 'OK']; 
        }else{
            throw new ForbiddenHttpException('you are not allowed' ,'407'); 
        }
    }
    public function actionDelcol(){
        if(!Yii::$app->user->isGuest){
            $post = Yii::$app->request->post();
            $user = Yii::$app->user->identity; 
            $delNum = 0;
            foreach($post['deletedIds'] as $d){
                $col = Usercollect::findOne(['frontuserid'=>$user->uid , 'transferlineid' => $d , 'isdeleted' => 0]);
                if(empty($col)){
                    throw new ForbiddenHttpException('trainline id('.$d.') is wrong' ,'408'); 
                }
                $col->isdeleted = 1;
                $col->datetime = date('Y-m-d H:i:s' , time());
                if($col->save()){
                    $delNum++;
                }else{
                    throw new ForbiddenHttpException('collect is not deleted succeed' ,'422'); 
                }
            }
            return ['code'=>200 , 'message'=>'OK' , 'deelNums' => $delNum];
        }else{
            throw new ForbiddenHttpException('you are not allowed' ,'407'); 
        }
    }
}
