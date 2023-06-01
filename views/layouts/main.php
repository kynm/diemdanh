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
        <meta name="google-site-verification" content="jyVCK93M5I1ZxnLA5jJXdtKBlPHkQAKqjCIuuT_cx50" />
        
        <link rel="icon" href="<?= Url::to(Yii::$app->homeUrl) ?>favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,300italic,400italic,600italic">
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon"  href="https://vnpt.com.vn/design/images/icon.png" type="image/x-icon" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <base href="/"> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    </head>
    <body class="skin-blue layout-top-nav">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>
        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <span class="pull-right" ><b>Phiên bản</b> 1.0</span>
    </div>
    <strong><a>VNPT HÀ NAM , TRUNG TÂM CNTT</a> &copy; 2022</strong>
    <br>
    Địa chỉ: 144 Trần Phú, Quang Trung, Phủ Lý, Hà Nam.
    <br>
</footer>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
