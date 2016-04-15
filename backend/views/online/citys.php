<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
$this->title = '上线城市数据';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bigHeader'] = '上线城市';
$this->params['smallHeader'] = '';
$this->params['startBarConfig'] = $startBarConfig;
$this->params['sideBarConfig'] = $sideBarConfig;
$this->params['sideBarConfig']['dataResult']['items'][0]['isAc']  = true;
$this->params['sideBarConfig']['dataResult']['items'][0]['items'][0]['isAc']  = true;
$this->registerCssFile( "http://cdn.king-liu.net/assets/global/plugins/datatables/datatables.min.css");
$this->registerCssFile("http://cdn.king-liu.net/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css");
$this->registerJsFile("http://cdn.king-liu.net/assets/global/scripts/datatable.js");
$this->registerJsFile("http://cdn.king-liu.net/assets/global/plugins/datatables/datatables.min.js");
$this->registerJsFile("http://cdn.king-liu.net/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js");
$this->registerJsFile("http://go.king-liu.net/table-datatables-managed.js");
?>
                                    <table class="table table-striped table-bordered table-hover order-column" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>出发城市</th>
                                                <th>目的城市</th>
                                                <th> 路线 </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($rows as $r){
                                            foreach($rows as $d){
                                                if($r['id'] == $d['id']){
                                                    continue;
                                                }
                                            echo'
                                            <tr class="odd gradeX">
                                                <td> '.$r['name'].' </td>
                                                <td>
                                                   '.$d['name'].' 
                                                </td>
                                                <td><a href="'.Url::toRoute(['online/trainlines' , 'from' => $r['id']  , 'to' => $d['id']]).'" target="_blank"><button type="button" class="btn btn-circle btn-primary">查看路线</button></a></td>
                                                </tr>';
                                            }
                                        
                                        }
                                        ?>
                                        </tbody>
                                    </table>
