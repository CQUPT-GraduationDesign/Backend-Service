<?php
/**
 * @author lk1ngaa7@gmail.com
 * @brief used for backend sys page header 
 * */
namespace backend\components;
use yii\base\Widget;
class pageHeader extends Widget{
	public $bigHeader;
	public $smallHeader;
	public function init(){
		parent::init();
        if(empty($this->bigHeader)){
            $this->bigHeader = "主标题";
        }
        if(empty($this->smallHeader)){
            $this->smallHeader = "副标题";
        }

    }
    public function run(){
       return '<h3 class="page-title">'.$this->bigHeader.'<small>'.$this->smallHeader.'</small></h3>';
    }  
}
