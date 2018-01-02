<?php 
use yii\helpers\Html;
use yii\helpers\Url;
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