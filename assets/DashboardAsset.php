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
        'css/AdminLTE.min.css',
        'css/font-awesome.min.css',
        'css/ionicons.min.css',
        'css/bootstrap-theme.min.css',
        'css/bootstrap.min.css',
        'css/_all-skins.min.css',
        'plugins/iCheck/blue.css',
        'css/site.css',
    ];
    public $js = [
        // 'js/bootstrap.min.js',
        // 'js/jquery.min.js',
        'js/jquery-ui.min.js',
        'js/adminlte.min.js',
        'plugins/fastclick/fastclick.js',
        'plugins/sparkline/jquery.sparkline.min.js',
        'plugins/slimscroll/jquery.slimscroll.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
