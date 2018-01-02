<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/AdminLTE.min.css',
        // 'css/font-awesome.min.css',
        // 'css/ionicons.min.css',
        // 'css/bootstrap-theme.min.css',
        // 'css/bootstrap.min.css',
        // 'css/_all-skins.min.css',
        'plugins/iCheck/blue.css',
        'css/magnific-popup.css',
        'css/site.css',
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/font-awesome/css/font-awesome.min.css',
        'bower_components/Ionicons/css/ionicons.min.css',
        'dist/css/AdminLTE.min.css',
        'dist/css/skins/_all-skins.min.css',
        'bower_components/morris.js/morris.css',
        'bower_components/jvectormap/jquery-jvectormap.css',
        'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        'bower_components/bootstrap-daterangepicker/daterangepicker.css',
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
    ];
    public $js = [
        'js/jquery-ui.min.js',
        'js/adminlte.min.js',
        'plugins/fastclick/fastclick.js',
        'plugins/sparkline/jquery.sparkline.min.js',
        'plugins/slimscroll/jquery.slimscroll.min.js',
        'js/jquery.magnific-popup.min.js',
        'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
