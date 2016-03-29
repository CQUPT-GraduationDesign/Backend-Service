<?php
use yii\widgets\Breadcrumbs;
use backend\components\pageHeader;
use backend\components\backendSidebar;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?= $this->title ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="go-go-go" name="description" />
        <meta content="lk1ngaa7@gmail.com" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <?php $this->head() ?>
        <link href="http://cdn.king-liu.net/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="http://cdn.king-liu.net/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="http://cdn.king-liu.net/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
     </head>
    <!-- END HEAD -->
<?php $this->beginBody() ?>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="#">
                        <img src="http://cdn.king-liu.net/assets/layouts/layout/img/logo.png" alt="logo" class="logo-default"></a>
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN NOTIFICATION DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        
                        <!-- END NOTIFICATION DROPDOWN -->
                        <!-- BEGIN INBOX DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        
                        <!-- END INBOX DROPDOWN -->
                        <!-- BEGIN TODO DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        
                        <!-- END TODO DROPDOWN -->
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="http://cdn.king-liu.net/assets/layouts/layout/img/avatar3_small.jpg">
                                <span class="username username-hide-on-mobile"><?php
                                                                                    if(!\Yii::$app->user->isGuest){
                                                                                        echo \Yii::$app->user->identity->username;
                                                                                    }else{
                                                                                        echo '未登录';
                                                                                    }
                                                                                ?></span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li class="divider"> </li>
                                <li>
                                <a href="<?= \Yii::$app->urlManager->createUrl('login/logout') ?>">
                                        <i class="icon-key"></i>登出</a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        
                        <!-- END QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <?= backendSidebar::widget([
            		'startBarArray' => isset($this->params['startBarConfig']) ? $this->params['startBarConfig'] : [],
            		'sideBarArray' => isset($this->params['sideBarConfig']) ? $this->params['sideBarConfig'] : [],
            ]) ?>
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content" style="min-height:1236px">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
        		<?= Breadcrumbs::widget([
			        'options' => ['class' => 'page-breadcrumb'],
			        'itemTemplate' => '<li>{link}<i class="fa fa-circle"></i></li>',
			        'activeItemTemplate' => '<li><span>{link}</span></li>',
            		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        		]) ?>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <?= pageHeader::widget([
            		    'bigHeader' => isset($this->params['bigHeader']) ? $this->params['bigHeader'] : "",
            		    'smallHeader' => isset($this->params['smallHeader']) ? $this->params['smallHeader'] : "",
                    ]) ?>
                    <!--
                     <h3 class="page-title"> Blank Page Layout
                        <small>blank page layout</small>
                    </h3>
                    --->
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
		            	<?php echo $content ;?>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner">Graduation Design Powerd By <a href="http://www.king-liu.net" target="_blank">lk1ngaa7</a>
            </div>
            <div class="scroll-to-top" style="display: none;">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
	    <script src="http://cdn.king-liu.net/assets/global/plugins/respond.min.js"></script>
	    <script src="http://cdn.king-liu.net/assets/global/plugins/excanvas.min.js"></script> 
	    <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="http://cdn.king-liu.net/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="http://cdn.king-liu.net/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="http://cdn.king-liu.net/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="http://cdn.king-liu.net/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="http://cdn.king-liu.net/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="http://cdn.king-liu.net/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="http://cdn.king-liu.net/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="http://cdn.king-liu.net/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="http://cdn.king-liu.net/assets/global/scripts/app.min.js" type="text/javascript"></script>
<?php $this->endBody() ?>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="http://cdn.king-liu.net/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="http://cdn.king-liu.net/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="http://cdn.king-liu.net/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
</body>
</html>
<?php $this->endPage() ?>
