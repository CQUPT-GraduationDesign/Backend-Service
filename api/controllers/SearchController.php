<?php
namespace api\controllers;
use Yii;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use api\models\Frontuser;

class SearchController extends Controller {
    private $clientCityMap = [
        '100010000' => '1' ,
        '2300010000' => '14' ,
        '1200010000' => '16' ,
        '800010000' => '9' ,
        '900010000' => '6' ,
        '1300010000' => '17' ,
        '1900010000' => '23' ,
        '300110000' => '8' ,
        '1100010000' => '15' ,
        '600010000' => '10' ,
        '1500010000' => '22' ,
        '1400020000' => '11' ,
        '3000010000' => '25' ,
        '2400010000' => '21' ,
        '700010000' => '12' ,
        '1400010000' => '19' ,
        '200010000' => '2' ,
        '1300020000' => '18' ,
        '300210000' => '5' ,
        '1800010000' => '20' ,
        '2100010000' => '24' ,
        '500010000' => '3' ,
        '400010000' => '7' ,
        '1000010000' => '4' ,
        '2000010000' => '13' , 
    ];
    private $_trainCachePre = 'trainTransfer_';
    public function actionTrain(){
        $request = Yii::$app->request;
        if($request->isPost){
            $mem = Yii::$app->memcache;
            $redis = Yii::$app->rediscache;
            $post = $request->post();
            if(empty($post['from']) ||
               empty($post['to'])   ||
               empty($post['type']) ||
               empty($post['page']) ||
               empty($post['counts'])){
                    throw new ForbiddenHttpException('POST data error' ,'409'); 
               }else{
                    $clientIds = array_keys($this->clientCityMap);
                    if(!in_array($post['from'] , $clientIds) || !in_array($post['to'] , $clientIds)){
                        throw new ForbiddenHttpException('cityid is wrong' ,'410'); 
                    }else{
                        $post['from'] = $this->clientCityMap[$post['from']];
                        $post['to']   = $this->clientCityMap[$post['to']];
                    }
                    $key = $this->_trainCachePre.$post['from'].'_'.$post['to'].'_'.$post['type']; 
                    if($mem->exists($key)){
                        return $mem->get($key);
                    }else if($redis->exists($key)){
                        return $redis->get($key);
                    }else{
                        return $key;
                    }
               }
        }else{
            throw new ForbiddenHttpException('Only support POST HTTP verb' ,'403'); 
        } 
    } 
    private function _getPageData(){
    
    }
}
