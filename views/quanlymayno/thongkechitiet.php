<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;
use app\models\Nhanvien;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;
?>
    <a class="btn btn-primary btn-flat" href="<?= Url::to(['quanlymayno/gianhienlieu'])?>" target="_blank">Xem giá nhiên liệu</a>
    <br>
    <br>
<div class="tramvt-search">

    <div class="row">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            // 'action' => 'vnpt_mds/quanlymayno/thongkeketoan'
        ]); ?>
        <div class="col-md-3 col-xs-3">
            <?= Select2::widget([
                'name' => 'ID_DONVI',
                'id' => 'ID_DONVI',
                'value' => $inputs['ID_DONVI'],
                'data' => $dsDonvi,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Chọn đơn vị'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]); ?>
        </div>
        <div class="col-md-2 col-xs-2">
            <?= Select2::widget([
                'name' => 'THANG',
                'id' => 'THANG',
                'value' => $inputs['THANG'],
                'data' => $months,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Chọn tháng'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]); ?>
        </div>
        <div class="col-md-2 col-xs-2">
            <?= Select2::widget([
                'name' => 'NAM',
                'id' => 'NAM',
                'value' => $inputs['NAM'],
                'data' => $years,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Chọn năm'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]); ?>
        </div>
        <div class="col-md-2 col-xs-2">
            <?= Html::submitButton(
                '<i class="fa fa-search"></i> Xem báo cáo', 
                [
                    'class'=>'btn btn-primary btn-flat',
                    'id' => 'searchBtn',
                    
                ])
            ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php if($isprint) { ?>
            <div class="col-md-1 col-xs-1">
                <a class="btn btn-primary btn-flat" href="<?= Url::to(['quanlymayno/inchitietbaoduongthang?ID_DONVI=' . $inputs['ID_DONVI'] . '&NAM=' . $inputs['NAM'] . '&THANG=' . $inputs['THANG']])?>" target="_blank">In kết quả</a>
            </div>
        <?php }?>
    </div>
</div>

<div class="tramvt-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?= $this->render('_table_data_chitiet', [
                    'data' => $data,
                ]) ?>
            </div>
        </div>
    </div>
</div>