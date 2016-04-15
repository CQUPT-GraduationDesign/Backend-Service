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
use yii\web\BadRequestHttpException;
/**
 * fetch data show controller for show and handle data request
 * */
class FetchController extends BackendabstractController {
    public function actionTrainin(){
        $this->render('trainin');
    }
    public function actionTraininapi(){
        $request = Yii::$app->request;
        if($request->isAjax){
            $query = new Query();
            $re = [];
            $get = $request->get();  
            $re['draw'] = $get['draw'];
            $query->select('id')->from('trainlinesin');
            $re['recordsTotal'] = $query->count();
            if(!empty($get['columns'][$get['order'][0]['column']]['data'])){
                $order['key']  = $get['columns'][$get['order'][0]['column']]['data'];
                $order['sort'] = $get['order'][0]['dir'];
            }
            $data = $this->_getDataTableData('trainlinesin' , $get['search']['value'] , $get['start'] , $get['length'] , $order);
            $re['recordsFiltered'] = $data['count'];
            $re['data'] = $data['data'];
            return json_encode($re);
        }else{
            throw new BadRequestHttpException('only ajax' , 406);
        }
    }
    public function actionTrainout(){
        $this->render('trainout');
    }
    public function actionTrainoutapi(){
        $request = Yii::$app->request;
        if($request->isAjax){
            $query = new Query();
            $re = [];
            $get = $request->get();  
            $re['draw'] = $get['draw'];
            $query->select('id')->from('trainlinesout');
            $re['recordsTotal'] = $query->count();
            if(!empty($get['columns'][$get['order'][0]['column']]['data'])){
                $order['key']  = $get['columns'][$get['order'][0]['column']]['data'];
                $order['sort'] = $get['order'][0]['dir'];
            }
            $data = $this->_getDataTableData('trainlinesout' , $get['search']['value'] , $get['start'] , $get['length'] , $order);
            $re['recordsFiltered'] = $data['count'];
            $re['data'] = $data['data'];
            return json_encode($re);
        }else{
            throw new BadRequestHttpException('only ajax' , 406);
        }
    }
    private function _getDataTableData($tableName  , $search , $start , $length , $order = null){
        $query = new Query(); 
        $orderConf = [
                    'asc' => SORT_ASC,
                    'desc' => SORT_DESC,
                ];
        $query->select('cityname , fromtrain , totrain , traintype , trainno , starttime , endtime')
                    ->from($tableName);
        if(!empty($search)){
            $query->orWhere(['like' , 'cityname' , $search]);
            $query->orWhere(['like' , 'fromtrain' , $search]);
            $query->orWhere(['like' , 'totrain' , $search]);
            $query->orWhere(['like' , 'traintype' , $search]);
            $query->orWhere(['like' , 'trainno' , $search]);
        }
        if(!empty($order)){
            $query->addOrderBy([$order['key'] => $orderConf[$order['sort']]]);
        }
        $re['count'] = $query->count();
        $query->offset($start)->limit($length);
        $re['data'] = array_values($query->all());
        return $re;
    }

}
