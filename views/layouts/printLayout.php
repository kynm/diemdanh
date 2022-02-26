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
        <link rel="icon" href="<?= Url::to(Yii::$app->homeUrl) ?>favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,300italic,400italic,600italic">
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <base href="/"> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <style type="text/css">
            .fixed {
                  table-layout: fixed;
                }
.datatable table {
  border-collapse: collapse;
}

.datatable table, th, td {
  border: 1px solid black;
  padding-left: 3px;
}
        </style>
        </style>
        <script type="text/javascript">
                function printDiv() 
                {
                    $("#button-print").hide();
                    $("#backlink").hide();
                  window.print();
                }
    var beforePrint = function() {
        // $("#button-print").hide();
    };

    var afterPrint = function() {
        $("#button-print").show();
        $("#backlink").show();
    };

    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                beforePrint();
            } else {
                afterPrint();
            }
        });
    }

    window.onbeforeprint = beforePrint;
    window.onafterprint = afterPrint;

        </script>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="skin-blue layout-top-nav">
        <?= $content ?>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
