<?php

use app\models\ActivitiesLog;
use app\models\Tramvt;
use app\models\Dotbaoduong;
use yii\helpers\Url;

/* @var $this yii\web\View */

$countTramvt = Tramvt::find()->count();
$countKehoach = Dotbaoduong::find()->where(['TRANGTHAI' => 'Kế hoạch' ])->count();
$countThuchien = Dotbaoduong::find()->where(['TRANGTHAI' => 'Đang thực hiện' ])->count();
$countHoanthanh = Dotbaoduong::find()->where(['TRANGTHAI' => 'Kết thúc' ])->count();

$this->title = 'Dashboard';
?>
<div class="site-index" style="margin-top: 15px ">
    <div class="body-content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= $countTramvt ?></h3>

              <p>Trạm BTS</p>
            </div>
            <div class="icon">
              <i class="fa fa-map-marker"></i>
            </div>
            <a href="<?= Url::to(['tramvt/index']) ?>" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $countKehoach ?><sup style="font-size: 20px"> đợt</sup></h3>

              <p>Kế hoạch</p>
            </div>
            <div class="icon">
              <i class="fa fa-bar-chart"></i>
            </div>
            <a href="<?= Url::to(['dotbaoduong/danhsachkehoach']) ?>" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= $countThuchien ?><sup style="font-size: 20px"> đợt</sup></h3>

              <p>Đang thực hiện</p>
            </div>
            <div class="icon">
              <i class="fa fa-cogs"></i>
            </div>
            <a href="<?= Url::to(['dotbaoduong/danhsachthuchien']) ?>" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?= $countHoanthanh ?><sup style="font-size: 20px"> đợt</sup></h3>

              <p>Hoàn thành</p>
            </div>
            <div class="icon">
              <i class="fa fa-pie-chart"></i>
            </div>
            <a href="<?= Url::to(['dotbaoduong/danhsachketqua']) ?>" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Recently Actions -->
      <div class="row">
          <div class="col-lg-7">
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
                <?php $activities = ActivitiesLog::find()->orderBy(['activity_log_id' => SORT_DESC])->limit(5)->all(); 
                  foreach ($activities as $activity) {
                    echo '<li class="item">
                    <div class="product-img">
                      <img src="'. Yii::getAlias('@web').'/'.$activity->user->avatar .'" class="img-circle" alt="Avatar Image">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title"><i class="'. $activity->activityType->class .'"></i> '. $activity->activityType->activity_name .'
                        <span class="label label-info pull-right">'.date("d/m/y H:m:s", $activity->create_at) .'</span></a>
                      <span class="product-description">
                            '. $activity->description .'
                          </span>
                    </div>
                  </li>';
                  }
                ?>
                  <!-- /.item -->
                </ul>
              </div>
              <!-- /.box-body -->
              <div class="box-footer text-center">
                <a href="<?= Url::to(['activities-log/index']) ?>" class="uppercase">Xem tất cả</a>
              </div>
              <!-- /.box-footer -->
            </div>
            <!-- /.box -->
          </div>
          <div class="col-lg-5">
            
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Các đợt bảo dưỡng sắp tới</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Đợt bảo dưỡng</th>
                    <th>Trưởng nhóm</th>
                    <th>Trạng thái</th>
                    <th>Thời gian</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $dotbds = Dotbaoduong::find()->orderBy(['NGAY_BD' => SORT_ASC])->all();
                  $i = 0;
                  foreach ($dotbds as $dotbd) {
                    if (($dotbd->NGAY_BD >= date('Y-m-d')) && true) {
                      if ($i == 5) {
                        break;
                      }
                      $i++;
                  ?>
                    <tr>
                      <td><a href="<?= Url::to(['dotbaoduong/view', 'id' => $dotbd->ID_DOTBD]) ?>"><?= $dotbd->MA_DOTBD ?></a></td>
                      <td><?= $dotbd->tRUONGNHOM->TEN_NHANVIEN ?></td>
                      <td><span class="label <?= ($dotbd->TRANGTHAI == 'Kế hoạch') ? 'label-success' : '' ?> <?= ($dotbd->TRANGTHAI == 'Đang thực hiện') ? 'label-warning' : '' ?> <?= ($dotbd->TRANGTHAI == 'Kết thúc') ? 'label-danger' : '' ?>"><?= $dotbd->TRANGTHAI ?></span></td>
                      <td>
                        <div class="sparkbar"><?= $dotbd->NGAY_BD ?></div>
                      </td>
                    </tr>
                  <?php }
                    
                  } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="text-center">
                <a href="<?= Url::to(['dotbaoduong/danhsachkehoach']) ?>" class="btn btn-sm btn-default btn-flat">Xem tất cả</a>
              </div>
            </div>
            <!-- /.box-footer -->
          </div>
          </div>
      </div>

    </div>
</div>
<?php $this->registerJS("$('#calendar').datepicker();") ?>