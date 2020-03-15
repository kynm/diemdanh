<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Thietbitram;
?>
<header class="main-header">
    <a href="<?= Url::home() ?>" class="logo">
        <span class="logo-mini"><i><img src="<?= Yii::getAlias('@web') ?>/dist/img/logo_small.png" alt="logo"></i></span>
        <span class="logo-lg"><i style="float: left"><img src="<?= Yii::getAlias('@web') ?>/dist/img/logo_small.png" alt="logo"></i> <b>VNPT</b>MDS</span>
    </a>
    <?= Html::csrfMetaTags() ?>
    <nav class="navbar navbar-static-top" role="navigation">
      <nav class="">
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li><a href="<?= Url::to(['site/baoduong'])?>">
                  Bảo dưỡng
                </a></li>
              <li class="task-menu">
                <a href="<?= Url::to(['site/logout'])?>" data-method="post">
                  <i class="fa fa-sign-out"></i> Đăng xuất
                </a>
              </li>
            </ul>
        </div>
      </nav>
    </nav>
</header>
