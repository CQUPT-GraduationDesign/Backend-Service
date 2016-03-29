<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = '后台首页';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bigHeader'] = '首页';
$this->params['smallHeader'] = '首页';
$this->params['startBarConfig'] = $startBarConfig;
$this->params['sideBarConfig'] = $sideBarConfig;
$this->params['startBarConfig']['title']['isAc']  = true;
$this->params['startBarConfig']['item'][0]['isAc']  = true;
?>
<div class="site-index">
 this is index!!!
</div>
