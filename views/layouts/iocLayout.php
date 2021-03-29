<?php
use yii\helpers\Html;
use yii\helpers\Url;
// use yii\bootstrap\Modal;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        // app\assets\AppAsset::register($this);
        app\assets\DashboardAsset::register($this);
    }
    dmstr\web\AdminLteAsset::register($this);
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <link rel="icon" href="<?= Url::to(Yii::$app->homeUrl) ?>/dist/img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,300italic,400italic,600italic">
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <base href="/"> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
 <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AvfTOCp6deFCiiaKwzdfi_Z10QhqZgpDDbKDXEb6_Wengs8XpdH1FqwoDWWQa1So' async defer></script>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="skin-blue layout-top-nav">
        <?= $this->render(
            'header_ioc.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>
        <?= $this->render(
            'ioccontent.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>