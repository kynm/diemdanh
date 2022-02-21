<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Thietbitram;
?>
    <header class="main-header">
        <!-- Logo -->
        <a href="<?= Url::home() ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><i><img src="<?= Yii::getAlias('@web') ?>/dist/img/logo_small.png" alt="logo"></i></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><i style="float: left"><img src="<?= Yii::getAlias('@web') ?>/dist/img/logo_small.png" alt="logo"></i> <b>VNPT</b>MDs</span>
        </a>
        <?= Html::csrfMetaTags() ?>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <ul class="nav navbar-nav">
            <li><a href="<?= Url::to(['/'])?>">Dashboard</a></li>
              <li><a href="<?= Url::to(['baohong/index'])?>">Báo hỏng</a></li>
            </ul>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="task-menu">
                <a href="<?= Url::to(['site/logout'])?>" data-method="post">
                  <i class="fa fa-sign-out"></i> Đăng xuất
                </a>
              </li>
            </ul>
          </div>
        </nav>
    </header>   
