<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Baoduongtong;
use yii\helpers\ArrayHelper;
?>
<h3>Danh sách bảo dưỡng cá nhân</h3>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['dotbaoduongcanhan/danhsach']) ?>">
            <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-clock-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Công việc trong kế hoạch</span>
              <span class="info-box-number"><small>%</small></span>
            </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['dotbaoduongcanhan/danhsach', 'trangthai' => 'dangthuchien']) ?>">
            <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Công việc đang thực hiện</span>
              <span class="info-box-number"><small>%</small></span>
            </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['dotbaoduongcanhan/danhsach', 'trangthai' => 'chuahoanthanh']) ?>">
            <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-clock-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Chờ tổ trưởng xác nhận</span>
              <span class="info-box-number"><small>%</small></span>
            </div>
            </div>
        </a>
    </div>
</div>
<div class="box box-primary">
    <div class="table-responsive">
    <?php
    Pjax::begin();
        echo GridView::widget([
            'dataProvider' => $planProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'MA_DOTBD',
                [
                    'attribute' => 'ID_TRAM',
                    'value' => 'tRAMVT.TEN_TRAM'
                ],
                [
                    'attribute' => 'ID_NHANVIEN',
                    'value' => 'nHANVIEN.TEN_NHANVIEN'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{thuchien} {xem}',
                    'buttons' => [
                        'xem' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'lead-view'),
                            ]);
                        },
                        'thuchien' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'lead-update'),
                            ]);
                        },

                    ],
                ],
            ],
        ]);
    Pjax::end();
    ?>
    </div>
</div>

