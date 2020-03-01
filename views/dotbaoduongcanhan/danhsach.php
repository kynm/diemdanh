<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<h1>Danh sách bảo dưỡng cá nhân</h1>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['dotbaoduongcanhan/danhsach']) ?>">
            <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Công việc trong kế hoạch</span>
              <span class="info-box-number">90<small>%</small></span>
            </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['dotbaoduongcanhan/danhsach', 'trangthai' => 'dangthuchien']) ?>">
            <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Công việc đang thực hiện</span>
              <span class="info-box-number">90<small>%</small></span>
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
        <?php foreach ($baoduong['DS_DotBaoDuong'] as $dotbaodung): ?>
            <li class="item">
              <div>
                <span href="javascript:void(0)" class="product-title"><?= Html::encode("{$dotbaodung->MA_DOTBD} ({$dotbaodung->ID_NHANVIEN})") ?></span>
                  <span class=" pull-right">
                    <?php if($trangthai == 'kehoach') {?>
                        <?= Html::a('Thực hiện', ['dotbaoduongcanhan/thuchien', 'id' => $dotbaodung->ID_DOTBD], ['class' => 'btn btn-success']) ?>
                    <?php };?>
                    <?= Html::a('Chi tiết', ['dotbaoduongcanhan/xem', 'id' => $dotbaodung->ID_DOTBD], ['class' => 'btn btn-warning']) ?>
                </span>
                <span class="product-description">
                    <?= Html::encode("{$dotbaodung->TRANGTHAI}") ?>
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
