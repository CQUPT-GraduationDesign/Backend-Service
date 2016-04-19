<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = '后台首页';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bigHeader'] = '首页';
$this->params['smallHeader'] = '监控信息';
$this->params['startBarConfig'] = $startBarConfig;
$this->params['sideBarConfig'] = $sideBarConfig;
$this->params['startBarConfig']['title']['isAc']  = true;
$this->params['startBarConfig']['item'][0]['isAc']  = true;
$this->registerCssFile( "http://cdn.king-liu.net/assets/global/plugins/morris/morris.css");
$this->registerJsFile("http://cdn.king-liu.net/assets/global/plugins/morris/morris.min.js");
// build AMD env for echarts
$this->registerJsFile("http://echarts.baidu.com/build/dist/echarts.js");
$this->registerJsFile("http://cdn.king-liu.net/assets/pages/scripts/dashboard.min.js");
$this->registerJsFile("http://go.king-liu.net/echart-js/echarts.js");
?>
        <div class="site-index">
                <div class="row widget-row">
                        <div class="col-md-3">
                            <!-- BEGIN WIDGET THUMB -->
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                <h4 class="widget-thumb-heading">total memory</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-green fa fa-battery-full"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-subtitle">MB</span>
                                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= $mem[0] ?>"><?= $mem[0] ?></span>
                                    </div>
                                </div>
                            </div>
                            <!-- END WIDGET THUMB -->
                        </div>
                        <div class="col-md-3">
                            <!-- BEGIN WIDGET THUMB -->
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                <h4 class="widget-thumb-heading">total disk</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-red fa fa-battery-half"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-subtitle">GB</span>
                                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= $mem[1] ?>"><?= $mem[1] ?></span>
                                    </div>
                                </div>
                            </div>
                            <!-- END WIDGET THUMB -->
                        </div>
                        <div class="col-md-3">
                            <!-- BEGIN WIDGET THUMB -->
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                <h4 class="widget-thumb-heading">sys version</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-purple fa fa-industry"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-subtitle">centos</span>
                                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= $cpu[0] ?>"><?= $cpu[0] ?></span>
                                    </div>
                                </div>
                            </div>
                            <!-- END WIDGET THUMB -->
                        </div>
                        <div class="col-md-3">
                            <!-- BEGIN WIDGET THUMB -->
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                <h4 class="widget-thumb-heading">docker version</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-blue fa fa-hourglass"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-subtitle">version</span>
                                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= $cpu[1] ?>"><?= $cpu[1] ?></span>
                                    </div>
                                </div>
                            </div>
                            <!-- END WIDGET THUMB -->
                        </div>
                    </div>
<div class="row">
                        <div class="col-md-12">
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class=" icon-layers font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">mon chart</span>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body">
                                <div id="docker-1" style="width: 1600px;height:400px;"></div>                
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
