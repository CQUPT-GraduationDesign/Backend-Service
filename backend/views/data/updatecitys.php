       
<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
$this->title = '更新城市数据';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bigHeader'] = '城市数据';
$this->params['smallHeader'] = '当前城市是'.$city->name;
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
$this->registerJsFile("http://go.king-liu.net/update-citys-stations.js");
?>
    <input id="update-city-id" type="hidden" value="<?= $city->id ?>" >
     <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bubble font-green-sharp"></i>
                                        <span class="caption-subject font-green-sharp bold uppercase">当前选择的城市是：<?= $city->name ?> </span>
                                        <button data-toggle="modal" href="#modal-train" id="update-train-button" type="button" class="btn btn-circle blue-madison">更新车站</button>
                                        <button data-toggle="modal" href="#modal-plane" id="update-plane-button" type="button" class="btn btn-circle green-sharp">更新机场</button>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body">
                                    <ul class="nav nav-pills">
                                        <li class="">
                                            <a href="#tab_train" data-toggle="tab" aria-expanded="false"> 火车站 </a>
                                        </li>
                                        <li class="active">
                                            <a href="#tab_plane" data-toggle="tab" aria-expanded="true">机场</a>
                                        </li>
                                        <li class="">
                                            <a href="#tab_sug" data-toggle="tab" aria-expanded="false">建议</a>
                                        </li>
                                        <li class="">
                                            <a href="#tab_selected" data-toggle="tab" aria-expanded="false">已选择的</a>
                                        </li>
                                        
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade" id="tab_train">
                                        <?= $this->render('_trainTable.php' , [ 'rows' => $trainRows ]) ?> 
                                        </div>
                                        <div class="tab-pane fade active in" id="tab_plane">
                                        <?= $this->render('_planeTable.php' , [ 'rows' => $planeRows ]) ?> 
                                        </div>
                                        <div class="tab-pane fade" id="tab_sug">
                                                 <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th> 名称</th>
                                                        <th> 地址 </th>
                                                        <th> 类型 </th>
                                                    </tr>
                                                </thead>
                                                    <tbody>
                                        <?php
                                            foreach($trainSug  as $t){
                                                echo '<tr>
                                                        <td>'.$t['name'].'</td>
                                                        <td>'.$t['address'].'</td>
                                                        <td>火车站</td>
                                                    </tr>';
                                            } 
                                            foreach($planeSug  as $t){
                                                echo '<tr>
                                                        <td>'.$t['name'].'</td>
                                                        <td>'.$t['address'].'</td>
                                                        <td>机场</td>
                                                    </tr>';
                                            } 
                                        ?>
                                                    </tbody>
                                        </table>
                                        </div>
                                        <div class="tab-pane fade" id="tab_selected">
                                                 <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th> 名称</th>
                                                        <th> 类型 </th>
                                                        <th> 代码 </th>
                                                    </tr>
                                                </thead>
                                                    <tbody id="selected-data-table">
                                                    <?php
                                                        foreach($selectedPlanes as $sp){
                                                            echo '<tr>
                                                                <td>'.$sp->name.'</td><td>机场</td>
                                                                <td>'.$sp->code.'</td>
                                                                <td><a href="'.Url::toRoute(['data/deletecityplanes' , 'id'=>$sp->id , 'cityid'=>$city->id ]).'">删除</a></td>
                                                                </tr>';
                                                        }
                                                        foreach($selectedTrains as $st){
                                                            echo '<tr>
                                                                <td>'.$st->name.'</td><td>火车站</td>
                                                                <td>'.$st->code.'</td>
                                                                <td><a href="'.Url::toRoute(['data/deletecitytrains' , 'id'=>$st->id ,'cityid' => $city->id ]).'">删除</a></td>
                                                                </tr>';
                                                        }
                                                    ?>
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade bs-modal-lg" id="modal-train" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">要给 <?= $city->name  ?> 添加这些车站吗?</h4>
                                                </div>
                                                <div class="modal-body">
                                                 <table class="table table-hover">
                                                    <tbody id="update-modal-table-train">
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id = "update-modal-train-quit" class="btn dark btn-outline" data-dismiss="modal">退出</button>
                                                    <button type="button" id = "update-modal-train-submit" class="btn green" data-dismiss = "modal">提交</button>
                                                </div>
                                            </div>
                                        </div>
                     </div>
                    <div class="modal fade bs-modal-lg" id="modal-plane" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">要给 <?= $city->name  ?> 添加这些机场吗?</h4>
                                                </div>
                                                <div class="modal-body">
                                                 <table class="table table-hover">
                                                    <tbody id="update-modal-table-plane">
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id = "update-modal-plane-quit" class="btn dark btn-outline" data-dismiss="modal">退出</button>
                                                    <button type="button" id = "update-modal-plane-submit" class="btn green" data-dismiss = "modal">提交</button>
                                                </div>
                                            </div>
                                        </div>
                     </div>
