<?php
use yii\widgets\LinkPager;

$this->title = '车站数据';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bigHeader'] = '车站';
$this->params['smallHeader'] = '火车车站';
$this->params['startBarConfig'] = $startBarConfig;
$this->params['sideBarConfig'] = $sideBarConfig;
$this->params['sideBarConfig']['dataConfig']['items']['staticData']['isAc']  = true;
$this->params['sideBarConfig']['dataConfig']['items']['staticData']['items'][0]['isAc']  = true;
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
                                                <th> id</th>
                                                <th>拼音缩写 </th>
                                                <th> 名称</th>
                                                <th> 拼音 </th>
                                                <th> 三字码</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($models as $m){
                                            echo'
                                            <tr class="odd gradeX">
                                                <td> '.$m->id.' </td>
                                                <td>
                                                   '.$m->shortalphabetic.' 
                                                </td>
                                                <td>'.$m->name.'</td>
                                                <td class="center">'.$m->alphabetic.'</td>
                                                <td>
                                                   '.$m->code.' 
                                                </td>
                                                </tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
