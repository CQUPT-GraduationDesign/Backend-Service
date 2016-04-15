<?php
use yii\widgets\LinkPager;
$this->title = '城市火车出路线';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bigHeader'] = '火车';
$this->params['smallHeader'] = '所有火车离开路线';
$this->params['startBarConfig'] = $startBarConfig;
$this->params['sideBarConfig'] = $sideBarConfig;
$this->params['sideBarConfig']['dataFetch']['items'][0]['isAc']  = true;
$this->params['sideBarConfig']['dataFetch']['items'][0]['items'][0]['isAc']  = true;
$this->registerCssFile( "http://cdn.king-liu.net/assets/global/plugins/datatables/datatables.min.css");
$this->registerCssFile("http://cdn.king-liu.net/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css");
$this->registerJsFile("http://cdn.king-liu.net/assets/global/scripts/datatable.js");
$this->registerJsFile("http://cdn.king-liu.net/assets/global/plugins/datatables/datatables.min.js");
$this->registerJsFile("http://cdn.king-liu.net/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js");
$this->registerJsFile("http://go.king-liu.net/datatable-js/datatables-fetched-trainout.js");
?>
<?php // render reused view ?>
<?php
    echo $this->render('_dataTable.php' , ['tableId' => 'dataTable-fetched-trainout']);
?>
