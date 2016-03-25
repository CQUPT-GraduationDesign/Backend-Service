<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
$this->title = '错误页面';
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>
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
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.useso.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="http://cdn.king-liu.net/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="http://cdn.king-liu.net/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="http://cdn.king-liu.net/assets/pages/css/error.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" page-500-full-page">
        <div class="row">
            <div class="col-md-12 page-500">
            <div class=" number font-red"> <?= $exception->statusCode ?> </div>
                <div class=" details">
                <h1><?= Html::encode($exception->name) ?></h1>
                    <div class="alert alert-danger">
                        <?= nl2br(Html::encode($exception->getMessage())) ?>
                    </div>
                    <a href="<?= Url::toRoute('index/index') ?>" class="btn red btn-outline"> Return home </a>
                        <br> </p>
                </div>
            </div>
        </div>
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
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>
</html>


