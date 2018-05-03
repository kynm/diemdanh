<?php

namespace app\assets;

use yii\web\AssetBundle;


class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/login.css',
        'css/site.css',
        // 'bower_components/bootstrap/dist/css/bootstrap.min.css',
        // 'bower_components/font-awesome/css/font-awesome.min.css',
        // 'bower_components/Ionicons/css/ionicons.min.css',
        // 'dist/css/AdminLTE.css',
    ];
    public $js = [
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
