       
<?php
use yii\widgets\LinkPager;
$this->title = '更新城市数据';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bigHeader'] = '城市数据';
$this->params['smallHeader'] = '当前城市是';
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
     <div class="row">
                        <div class="col-md-12">
                            
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bubble font-green-sharp"></i>
                                        <span class="caption-subject font-green-sharp bold uppercase">当前选择的城市是：兰州 </span>
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
                                        <div class="tab-pane fade" id="tab_selected">
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            
                        </div>
                        
                    </div>
