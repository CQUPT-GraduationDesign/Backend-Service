<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
class BackendabstractController extends Controller {
    protected $startBarConfig = [];
    protected $sideBarConfig  = [];
    /**
     *
     * @override
     * #notice not use startBarConfig and sideBarConfig as var name to views 
     * */
    public function render($view , $params = []){
        $this->initSideBarConfig();
        $params = array_merge($params , 
            [
                'startBarConfig' => $this->startBarConfig,
                'sideBarConfig'  => $this->sideBarConfig,
            ]); 
        echo parent::render($view , $params);
    }
    /**
     *
     * init the side bar config
     * */
    protected function initSideBarConfig(){
           $startBarConfig = [ 
                                   'title' => [
                                        'name' => '首页控制台',
                                        'isAc' => false,
                                    ],
                                    'item' => [
                                        ['name' => '控制台' , 'icon'=>'fa-bar-chart' , 'url' => Url::toRoute('index/index'),'isAc'=>false],
                                    ],
                                ];
            $sideBarConfig = [
                   'dataConfig' => [
                                        'headName' => '数据配置',
                                        'items' =>[
                                           'staticData'=> [
                                                'name' => '静态数据',
                                                'icon' => 'fa-pie-chart',
                                                'isAc' => false,
                                                'items' => [
                                                    ['name' => '车站','icon'=>'fa-train' ,'url' => Url::toRoute('data/train') , 'isAc'=>false],
                                                    ['name' => '机场','icon'=>'fa-plane' ,'url' => Url::toRoute('data/plane') , 'isAc'=>false],
                                                    ['name' => '上线城市','icon'=>'fa-map' ,'url' => Url::toRoute('data/citys') , 'isAc'=>false],
                                                ],
                                            ],
                                        ],    
                                    ],
                   'dataFetch' => [
                                        'headName' => '数据抓取',
                                        'items' =>[
                                            [
                                                'name' => '原始数据',
                                                'icon' => 'fa-tv',
                                                'isAc' => false,
                                                'items' => [
                                                        ['name' => '火车出图','icon'=>'fa-train' ,'url' => Url::toRoute('fetch/trainout') , 'isAc'=>false],
                                                        ['name' => '火车入图','icon'=>'fa-train' ,'url' => Url::toRoute('fetch/trainin') , 'isAc'=>false],
                                                        ['name' => '航班出图','icon'=>'fa-plane' ,'url' => Url::toRoute('fetch/planein') , 'isAc'=>false],
                                                        ['name' => '航班入图','icon'=>'fa-plane' ,'url' => Url::toRoute('fetch/planeout') , 'isAc'=>false],
                                                    ],
                                            ]    
                                        ],    
                                    ],
                   'dataResult' => [
                                        'headName' => '换乘路线',
                                        'items' =>[
                                            [
                                                'name' => '数据',
                                                'icon' => 'fa-tv',
                                                'isAc' => false,
                                                'items' => [
                                                        ['name' => '上线数据','icon'=>'fa-tv' ,'url' => Url::toRoute('result/online') , 'isAc'=>false],
                                                    ],
                                            ]    
                                        ],    
                                    ],

                                ];
            $this->startBarConfig = $startBarConfig;
            $this->sideBarConfig  = $sideBarConfig;
    }
}
