<?php
namespace api\controllers;

use yii\rest\ActiveController;
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
    /**
     * POST 
     * {'username':'' , 'password':''}
     * */      
    public function actionLogin(){
        return ['id'=>'hello'];
    }
}
