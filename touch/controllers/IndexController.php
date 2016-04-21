<?php
namespace touch\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * touch Index  controller
 */
class IndexController extends Controller{
    private $_cityConfig = [
                     "北京",
                     "上海",
                     "天津",
                     "西安",
                     "深圳",
                     "重庆",
                     "武汉",
                     "广州",
                     "成都",
                     "杭州",
                     "济南",
                     "南京",
                     "郑州",
                     "长春",
                     "哈尔滨",
                     "长沙",
                     "大连",
                     "沈阳",
                     "青岛",
                     "石家庄",
                     "南昌",
                     "合肥",
                     "福州",
                     "太原",
                     "兰州",
                    ]; 
    private $_trainCachePre = 'trainTransfer_';
    private $typeMap = [
        '1' => 'default',
        '2' => 'whole',
        '3' => 'onTrain',
        '4' => 'transfer',
    ];
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionSearch(){
        $request = Yii::$app->request;
        $get = $request->get();
        
        return $this->render('search');
    }
}
