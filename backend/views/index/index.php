<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = '后台首页';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bigHeader'] = '首页';
$this->params['smallHeader'] = '首页';
$this->params['startBarConfig'] = [ 
                                    'title' => [
                                        'name' => '首页控制台',
                                        'isAc' => true,
                                    ],
                                    'item' => [
                                        ['name' => '控制台' , 'icon'=>'fa-bar-chart' , 'url' =>'','isAc'=>true],
                                    ],
                                ];
$this->params['sideBarConfig'] = [
                                    [
                                        'headName' => '城1市',
                                        'name' => '城市信息',
                                        'icon' => 'fa-tv',
                                        'isAc' => false,
                                        'items' => [
                                            ['name' => '所有城市','icon'=>'fa-tv' ,'url' => Url::toRoute('index/error') , 'isAc'=>false],
                                        ],
                                    ],
                                    [
                                        'headName' => '城市',
                                        'name' => '城市信息',
                                        'icon' => 'fa-tv',
                                        'isAc' => false,
                                        'items' => [
                                            ['name' => '所有城市','icon'=>'fa-tv' ,'url' => Url::toRoute('index/index') , 'isAc'=>false],
                                        ],
                                    ],

                                ];
?>
<div class="site-index">
 this is index!!!
</div>
