<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\DashboardAsset;

DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>V</b>NPT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>VNPT</b>MDs</span>
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
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">new</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                      <li><!-- start notification -->
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                      <!-- end notification -->
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="dist/img/default_picture.png" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="dist/img/default_picture.png" class="img-circle" alt="User Image">

                    <p>
                        <?= Yii::$app->user->identity->username ?>
                      <small> Chức vụ: IT</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?= Url::to(['user/']) ?>" class="btn btn-default btn-flat">Manage Users</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?= Url::to(['site/logout'])?>" data-method="post" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
    </header>   

    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/default_picture.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>
                <?= Yii::$app->user->identity->username ?>
              </p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- search form (Optional) -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span>
            </div>
          </form>
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="<?= ($this->title == 'Nhân viên') ? 'active' : '' ?>"><a href="<?= Url::to(['nhanvien/index']) ?>"><i class="fa fa-users"></i> <span>Nhân viên</span></a></li>            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-building-o"></i>
                <span>Đơn vị</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?= ($this->title == 'Đơn vị chủ quản') ? 'active' : '' ?>"><a href="<?= Url::to(['donvi/index']) ?>"><i class="fa fa-bank"></i> <span>Danh sách đơn vị</span></a></li>
                <li class="<?= ($this->title == 'Đài viễn thông') ? 'active' : '' ?>"><a href="<?= Url::to(['daivt/index']) ?>"><i class="fa fa-home"></i> <span>Đài viễn thông</span></a></li>
                <li class="<?= ($this->title == 'Trạm viễn thông') ? 'active' : '' ?>"><a href="<?= Url::to(['tramvt/index']) ?>"><i class="fa fa-map-marker"></i> <span>Trạm viễn thông</span></a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-wrench"></i>
                <span>Bảo dưỡng</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <!-- <li class="<?= ($this->title == 'Các đợt bảo dưỡng') ? 'active' : '' ?>"><a href="<?= Url::to(['dotbaoduong/index']) ?>"><i class="fa fa-wrench"></i> <span>Các đợt bảo dưỡng</span></a></li> -->
                <li class="<?= ($this->title == 'Kehoachbdtbs') ? 'active' : '' ?>"><a href="<?= Url::to(['kehoachbdtb/index']) ?>"><i class="fa fa-list-alt"></i> <span>Kế hoạch bảo dưỡng</span></a></li>
                <li class="<?= ($this->title == 'Thuchienbds') ? 'active' : '' ?>"><a href="<?= Url::to(['thuchienbd/index']) ?>"><i class="fa fa-cog"></i> <span>Thực hiện bảo dưỡng</span></a></li>
                <li class="<?= ($this->title == 'Ketquas') ? 'active' : '' ?>"><a href="<?= Url::to(['ketqua/index']) ?>"><i class="fa fa-check-square-o"></i> <span>Kết quả</span></a></li>
              </ul>
            </li>
            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Thiết bị</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?= ($this->title == 'Nhóm thiết bị') ? 'active' : '' ?>"><a href="<?= Url::to(['nhomtbi/index']) ?>"><i class="fa fa-desktop"></i> <span>Nhóm thiết bị</span></a></li>
                <li class="<?= ($this->title == 'Loại thiết bị') ? 'active' : '' ?>"><a href="<?= Url::to(['thietbi/index']) ?>"><i class="fa fa-tablet"></i> <span>Loại thiết bị</span></a></li>
                <li class="<?= ($this->title == 'Thiết bị tại trạm') ? 'active' : '' ?>"><a href="<?= Url::to(['thietbitram/index']) ?>"><i class="fa fa-podcast"></i> <span>Thiết bị tại trạm</span></a></li>
              </ul>
            </li>            
            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-list"></i>
                <span>Nội dung bảo dưỡng</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?= ($this->title == 'Nội dung bảo dưỡng') ? 'active' : '' ?>"><a href="<?= Url::to(['noidungbaotri/index']) ?>"><i class="fa fa-edit"></i> <span>Định nghĩa nội dung</span></a></li>
            <li class="<?= ($this->title == 'Đề xuất nội dung') ? 'active' : '' ?>"><a href="<?= Url::to(['dexuatnoidung/index']) ?>"><i class="fa fa-list-alt"></i> <span>Đề xuất nội dung</span></a></li>
              </ul>
            </li>            
            
          </ul>
          <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside> 

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          
          <ol class="breadcrumb">
            <li><a href="<?= Url::to(['site/index']) ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= $this->title ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <?= $content ?>
        </section>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
