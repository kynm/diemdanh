<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Nhanvien;

$nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
?>    
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
                <?= $nhanvien->TEN_NHANVIEN ?>
              </p>
              <!-- Status -->
              <a href="#" data-method="post"><i class="fa fa-user-o"></i><?= $nhanvien->CHUC_VU ?></a>
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
            
            <li class="<?= ($this->title == 'Nhân viên') ? 'active' : '' ?>"><a href="<?= Url::to(['nhanvien/index']) ?>"><i class="fa fa-users"></i> <span>Quản lý nhân viên</span></a></li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-building-o"></i>
                <span>Đơn vị</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?= ($this->title == 'Đơn vị chủ quản') ? 'active' : '' ?>"><a href="<?= Url::to(['donvi/index']) ?>"><i class="fa fa-caret-right"></i> <span>Danh sách đơn vị</span></a></li>
                <li class="<?= ($this->title == 'Đài viễn thông') ? 'active' : '' ?>"><a href="<?= Url::to(['daivt/index']) ?>"><i class="fa fa-caret-right"></i> <span>Danh sách đài viễn thông</span></a></li>
                <li class="<?= ($this->title == 'Trạm viễn thông') ? 'active' : '' ?>"><a href="<?= Url::to(['tramvt/index']) ?>"><i class="fa fa-caret-right"></i> <span>Danh sách nhà trạm</span></a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i>
                <span>Công việc cá nhân</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?= ($this->title == 'Kế hoạch') ? 'active' : '' ?>"><a href="<?= Url::to(['congviec/kehoach']) ?>"><i class="fa fa-caret-right"></i> <span>Kế hoạch</span></a></li> 
                <li class="<?= ($this->title == 'Thực hiện') ? 'active' : '' ?>"><a href="<?= Url::to(['congviec/thuchien']) ?>"><i class="fa fa-caret-right"></i> <span>Thực hiện</span></a></li>
              </ul>
            </li>           

            <li class="treeview <?= (@$this->params['breadcrumbs'][0]['label']=='Các đợt bảo dưỡng') ? 'menu-open' : '' ?>">
              <a href="#">
                <i class="fa fa-wrench"></i>
                <span>Các đợt bảo dưỡng</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="<?= (@$this->params['breadcrumbs'][0]['label']=='Các đợt bảo dưỡng') ? 'display: block' : '' ?>">
                <li class="<?= ($this->title == 'Kế hoạch') ? 'active' : '' ?>"><a href="<?= Url::to(['dotbaoduong/danhsachkehoach']) ?>"><i class="fa fa-caret-right"></i> <span>Kế hoạch</span></a></li>
                <li class="<?= ($this->title == 'Thực hiện') ? 'active' : '' ?>"><a href="<?= Url::to(['dotbaoduong/danhsachthuchien']) ?>"><i class="fa fa-caret-right"></i> <span>Đang thực hiện</span></a></li>
                <li class="<?= ($this->title == 'Kết quả') ? 'active' : '' ?>"><a href="<?= Url::to(['dotbaoduong/danhsachketqua']) ?>"><i class="fa fa-caret-right"></i> <span>Đã kết thúc</span></a></li>
              </ul>
            </li>
            
            <li class="<?= ($this->title == 'Nhóm thiết bị') ? 'active' : '' ?>"><a href="<?= Url::to(['nhomtbi/index']) ?>"><i class="fa fa-tablet"></i> <span>Nhóm thiết bị</span></a></li>          

            <li class="<?= ($this->title == 'Thông tin cá nhân') ? 'active' : '' ?>"><a href="<?= Url::to(['user/edit-profile']) ?>"><i class="fa fa-user"></i> <span>Thông tin cá nhân</span></a></li>

          </ul>
          <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside> 