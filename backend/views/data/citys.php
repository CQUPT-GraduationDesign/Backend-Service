<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
$this->title = '上线城市数据';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bigHeader'] = '上线城市';
$this->params['smallHeader'] = '';
$this->params['startBarConfig'] = $startBarConfig;
$this->params['sideBarConfig'] = $sideBarConfig;
$this->params['sideBarConfig']['dataConfig']['items']['staticData']['isAc']  = true;
$this->params['sideBarConfig']['dataConfig']['items']['staticData']['items'][2]['isAc']  = true;
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
                                                <th>名称</th>
                                                <th>车站数目 </th>
                                                <th> 机场数目</th>
                                                <th> 操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($rows as $r){
                                            echo'
                                            <tr class="odd gradeX">
                                                <td> '.$r['id'].' </td>
                                                <td>
                                                   '.$r['name'].' 
                                                </td>
                                                <td>'.$r['trainstationnum'].'</td>
                                                <td class="center">'.$r['planestationnum'].'</td>
                                                <td><a href="'.Url::toRoute(['data/updatecitys' , 'id' => $r['id'] ]).'" target="_blank"><button type="button" class="btn btn-circle btn-primary">编辑</button></a></td>
                                                </tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
