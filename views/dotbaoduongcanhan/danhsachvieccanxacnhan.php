<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<h1>Danh sách bảo dưỡng cá nhân</h1>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['dotbaoduongcanhan/danhsachvieccanxacnhan']) ?>">
            <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-clock-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Danh sách công việc chưa xác nhận</span>
              <span class="info-box-number"><small>%</small></span>
            </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['dotbaoduongcanhan/danhsachvieccanxacnhan', 'trangthai' => 'ketthuc']) ?>">
            <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Công việc đã xác nhận</span>
              <span class="info-box-number"><small>%</small></span>
            </div>
            </div>
        </a>
    </div>
</div>
<?php foreach ($data as $baoduong): ?>

<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><?= Html::encode("{$baoduong['ThongTinTram']->TEN_TRAM}") ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <ul class="products-list product-list-in-box">
        <?php foreach ($baoduong['DS_DotBaoDuong'] as $dotbaoduong): ?>
            <li class="item">
              <div>
                <span href="javascript:void(0)" class="product-title"><?= Html::encode("{$dotbaoduong->MA_DOTBD} ({$dotbaoduong->ID_NHANVIEN})") ?></span>
                  <span class=" pull-right">
                    <?php if($dotbaoduong->TRANGTHAI == 'ketthuc') {?>
                      <button class="btn btn-success">Đã xác nhận</button>
                    <?php } elseif($dotbaoduong->TRANGTHAI == 'chuahoanthanh') {?>
                      <?= Html::a('Xác nhận', ['dotbaoduongcanhan/xacnhancongviec', 'id' => $dotbaoduong->ID_DOTBD], ['class' => 'btn btn-warning']) ?>
                    <?php }?>
                </span>
                <span class="product-description">
                    <?= Html::encode("{$dotbaoduong->TRANGTHAI}") ?>
                    </span>
              </div>
            </li>
        <?php endforeach; ?>
        <!-- /.item -->
      </ul>
    </div>
    <!-- /.box-footer -->
    </div>
<?php endforeach; ?>
