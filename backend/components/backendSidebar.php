<?php
/**
 * @author lk1ngaa7@gmail.com
 * @brief used for backend sys page sidebar
 *
 * */
namespace backend\components;
use Yii;
use yii\helpers\Url;
use yii\base\Widget;
class backendSidebar extends Widget{
    public $sideBarArray = array();
    public $startBarArray = array();
    private $startBarString = ''; 
    private $itemBarString = '';
    public function init(){
         if(empty($this->startBarArray) || !is_array($this->startBarArray)){
             $this->startBarString = $this->buildStartBar();
         }else{
             $this->startBarString = $this->buildStartBar($this->startBarArray);
         }
         if(empty($this->sideBarArray) || !is_array($this->sideBarArray)){
             $this->itemBarString = $this->buildItemBar(); 
         }else{
             $this->itemBarString = $this->buildItemBar($this->sideBarArray); 
         } 
    }
    private function buildStartBar($data = [
                                    'title' => [
                                        'name' => '默认sidebar',
                                        'isAc' => true,
                                    ],
                                    'item' => [
                                        ['name' => '控制台' , 'icon'=>'fa-bar-chart' , 'url' =>'','isAc'=>true],
                                    ],
                                ]){
        $headAcArr = [];
        if($data['title']['isAc']){
            $headAcArr['isOpen'] = "active open";
            $headAcArr['isSelected'] = '<span class="selected"></span>';
            $headAcArr['isArrowOpen'] = "open";
        } 
        $item = "";
        foreach($data['item'] as $k=>$v){
            $acArr = [];
            if($v['isAc']){
                $acArr['isOpen'] = "active open";
                $acArr['isSelected'] = '<span class="selected"></span>';
            }
            $item .= '<li class="nav-item start '.$acArr['isOpen'].'">
                                    <a href="'.$v['url'].'" class="nav-link ">
                                        <i class="fa '.$v['icon'].'"></i>
                                        <span class="title">'.$v['name'].'</span>
                                        '.$acArr['isSelected'].'
                                    </a>
                                    </li>';
            $acStr = "";
        }
        return  '<li class="nav-item start '.$headAcArr['isOpen'].'">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-home"></i>
                                <span class="title">'.$data['title']['name'].'</span>
                                '.$headAcArr['isSelected'].'
                                <span class="arrow '.$headAcArr['isArrowOpen'].'"></span>
                            </a>
                            <ul class="sub-menu">
                            '.$item.'
                            </ul>
                        </li>';
    }
    private function buildItemBar($data = [
                                    [
                                        'headName' => '城市',
                                        'name' => '城市信息',
                                        'icon' => 'fa-tv',
                                        'isAc' => false,
                                        'items' => [
                                            ['name' => '所有城市','icon'=>'fa-tv' ,'url' => '12211' , 'isAc'=>false],
                                        ],
                                    ],
                            ]){
        $items = "";
        foreach($data  as $k => $v){
            $headAc = "";
            if($v['isAc']){
                $headAc = "active open";
            }
            $items .= '<li class="heading">
                            <h3 class="uppercase">'.$v['headName'].'</h3>
                       </li>
                       <li class="nav-item  '.$headAc.'">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa '.$v['icon'].'"></i>
                                <span class="title">'.$v['name'].'</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">';
            foreach($v['items'] as $key => $value){
                $itemAc = "";
                if($value['isAc']){
                    $itemAc = "active open";
                }
                $items.='<li class="nav-item  '.$itemAc.'">
                            <a href="'.$value['url'].'" class="nav-link ">
                                <i class="fa '.$value['icon'].'"></i>
                                <span class="title">'.$value['name'].'</span>
                            </a>
                         </li>';
            }
            $items.='    </ul>
                    </li>';
        }
        return $items;
    }
    public function run(){
        echo '<!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper hide">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler"> </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                        '.$this->startBarString.$this->itemBarString.'
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->';
    }  
}
