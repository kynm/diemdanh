<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Noidungcongviec;
use app\models\NoidungcongviecSearch;
use app\models\Dotbaoduong;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Ketqua */

$this->title = 'Đợt '.$model->MA_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ketqua-view">
    <div class="box box-primary">
        <div class="box-body">
            <p class="form-inline">
                <div class="form-group col-md-3 col-sm-6">
                    <label>Trạm viễn thông</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->tRAMVT->TEN_TRAM ; ?>">
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Ngày bắt đầu</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->NGAY_BD ; ?>">
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Ngày kết thúc</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->NGAY_KT ; ?>">
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Nhóm trưởng</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->nHANVIEN->TEN_NHANVIEN ; ?>">
                </div>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'formatter' => [
                    'class' => 'yii\i18n\Formatter',
                    'nullDisplay' => '',
                ],
                'rowOptions' => function ($model) {
                    if ($model->KETQUA == 'Chưa đạt') {
                        return ['class' => 'danger'];
                    }
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [ 
                        'attribute' => 'ID_THIETBI',
                        'value' => 'tHIETBI.iDLOAITB.TEN_THIETBI'
                    ],
                    [ 
                        'attribute' => 'MA_NOIDUNG',
                        'value' => 'mANOIDUNG.NOIDUNG'
                    ],
                    [
                        'attribute' => 'ID_NHANVIEN',
                        'value' => 'nHANVIEN.TEN_NHANVIEN'
                    ],
                    [ 
                        'attribute' => 'KETQUA',
                        'value' => 'KETQUA',
                    ],
                    'GHICHU',
                ],
            ]); ?>
            
            <div class="row">
                <?php foreach ($images as $image) {  ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <a href="<?= Yii::$app->homeUrl .'uploads/'.$image->ANH ?>" class="thumbnail">
                            <img src="<?= Yii::$app->homeUrl .'uploads/'.$image->ANH ?>" class="img-responsive">
                        </a>
                        <p class="text-center"> <?= $image->nHANVIEN->TEN_NHANVIEN ?> - <?= $image->type == 1 ? 'Tổ trưởng' : 'Nhân viên' ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>        
</div>
            



<?php
$script = <<< JS
    $('.row').magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery:{
            enabled:true
        },
        removalDelay: 300,
        mainClass: 'mfp-with-zoom', 

        zoom: {
            enabled: true, 

            duration: 300, 
            easing: 'ease-in-out', 
            opener: function(openerElement) {
              return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });
JS;
$this->registerJs($script);
?>