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
                    'template' => '{xacnhancongviec}',
                    'buttons' => [
                        'xacnhancongviec' => function ($url, $model) {
                          if ($model->TRANGTHAI != 'ketthuc') {
                            return Html::a('<button class="btn btn-warning">Xác nhận</button>', $url, [
                                        'title' => Yii::t('app', 'lead-view')
                            ]);
                          } else {
                            return '<button class="btn btn-success">Đã kết thúc</button>';
                          }
                        }
                    ],
                ],
            ],
        ]);
    Pjax::end();
    ?>
    </div>
</div>