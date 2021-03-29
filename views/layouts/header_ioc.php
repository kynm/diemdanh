<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<header class="main-header">
    <?= Html::csrfMetaTags() ?>
    <nav class="navbar navbar-static-top" role="navigation">
      <nav class="">
          <div class="">
              <ul class="nav navbar-nav">
                <li><a href="<?= Url::to(['ioc/phanbothietbi'])?>">Bản đồ phân bố thiết bị</a></li>
                <li><a href="<?= Url::to(['ioc/phanbospliter'])?>">Phân bố spliter</a></li>
                <li><a href="<?= Url::to(['ioc/phanbothuebao'])?>">Phân bố thuê bao</a></li>
                <li><a href="<?= Url::to(['ioc/baocaothuebao'])?>">BC thuê bao theo thiết bị</a></li>
                <li><a href="<?= Url::to(['ioc/baocaothiphanthuebao'])?>">Thị phần thuê bao</a></li>
              </ul>
          </div>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li><a href="<?= Url::to(['/'])?>">Trang chủ</a></li>
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
