<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<div class="site-index" style="margin-top: 15px ">

    <div class="body-content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>Trạm BTS</p>
            </div>
            <div class="icon">
              <i class="fa fa-map-marker"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Kế hoạch</p>
            </div>
            <div class="icon">
              <i class="fa fa-bar-chart"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>Nhân viên</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Tình trạng</p>
            </div>
            <div class="icon">
              <i class="fa fa-pie-chart"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Recently Actions -->
      <div class="row">
          <div class="col-lg-8">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Hoạt động gần đây</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <ul class="products-list product-list-in-box">
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-50x50.gif" alt="Product Image">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title"><i class="fa fa-user-plus"></i> Thêm nhân viên
                        <span class="label label-info pull-right"><?= date('d/m/y H:m:s', time()); ?></span></a>
                      <span class="product-description">
                            <b>Admin</b>. đã thêm nhân viên mới - <b>User 001</b>
                          </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-50x50.gif" alt="Product Image">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title"><i class="fa fa-list-ol"></i> Lên kế hoạch
                        <span class="label label-info pull-right"><?= date('d/m/y H:m:s', time()); ?></span></a>
                      <span class="product-description">
                            <b>Admin</b>. đã lên kế hoạch bảo dưỡng - <b>NT001-Q4</b>
                          </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-50x50.gif" alt="Product Image">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Xbox One <span
                          class="label label-danger pull-right">$350</span></a>
                      <span class="product-description">
                            Xbox One Console Bundle with Halo Master Chief Collection.
                          </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-50x50.gif" alt="Product Image">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">PlayStation 4
                        <span class="label label-success pull-right">$399</span></a>
                      <span class="product-description">
                            PlayStation 4 500GB Console (PS4)
                          </span>
                    </div>
                  </li>
                  <!-- /.item -->
                </ul>
              </div>
              <!-- /.box-body -->
              <div class="box-footer text-center">
                <a href="javascript:void(0)" class="uppercase">View All Products</a>
              </div>
              <!-- /.box-footer -->
            </div>
            <!-- /.box -->
          </div>
          <div class="col-lg-4">
            <!-- Calendar -->
            <div class="box box-solid bg-blue-gradient">
              <div class="box-header">
                <i class="fa fa-calendar"></i>

                <h3 class="box-title">Calendar</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                  
                  <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body no-padding">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
      </div>

    </div>
</div>
<?php $this->registerJS("$('#calendar').datepicker();") ?>