<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
    <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><i><img src="dist/img/logo_small.png" alt="logo"></i></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><i style="float: left"><img src="dist/img/logo_small.png" alt="logo"></i> <b>VNPT</b>MDs</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- Notifications Menu -->
              <li class="notifications-menu">
                <!-- Menu toggle button -->
                <a href="<?= Url::to(['site/logout'])?>" data-method="post">
                  <i class="fa fa-sign-out"></i> Đăng xuất
                </a>
                
              </li>
            </ul>
          </div>
        </nav>
    </header>   
