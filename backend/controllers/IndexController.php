<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * index controller
 * */
class IndexController extends BackendabstractController {
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class'  => AccessControl::className(),
                'rules' =>[   
                    [
                       'allow' => true,
                       'actions' => ['index' , 'monsysapi'],
                    ], 
                    [
                       'allow' => true,
                       'actions' => ['error'],
                    ], 
                ],
    
            ],
        ];
    }
    
    public function actionIndex(){
        $dataPath = '/opt/data/mon/sys/';
        $cpu = file_get_contents($dataPath.'cpu.txt');
        $cpu = explode(' ' , $cpu);
        $mem = file_get_contents($dataPath.'mem.txt');
        $mem = explode(' ' , $mem);
        return $this->render('index' , [
            'cpu' => $cpu,
            'mem' => $mem,
        ]); 
    }
    public function actionMonsysapi(){
        $dataPath = '/opt/data/mon/sys/';
        $cpu = file_get_contents($dataPath.'cpu.txt');
        $cpu = explode(' ' , $cpu);
        $mem = file_get_contents($dataPath.'mem.txt');
        $mem = explode(' ' , $mem);
        $re['idle'] = $cpu[0];
        $re['mem'] = $mem[1]; 
        return json_encode($re);
    }
    public function actionError(){
        $exception = Yii::$app->errorHandler->exception;
        if($exception !== null) {
            return $this->renderPartial('error', ['exception' => $exception]);
        }else{
            $this->redirect(['index/index']);
        }
    }
}
