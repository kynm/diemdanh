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
<div class="tramvt-search">

    <div class="row">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => 'vnpt_mds/quanlymayno/thongkeketoan'
        ]); ?>
        <div class="col-md-3 col-xs-3">
            <?= Select2::widget([
                'name' => 'ID_DONVI',
                'id' => 'ID_DONVI',
                'value' => $inputs['ID_DONVI'],
                'data' => ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', [2,3,4,5,6,7]])->all(), 'ID_DONVI', 'TEN_DONVI'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Chọn đơn vị'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]); ?>
        </div>
        <div class="col-md-3 col-xs-3">
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
        <div class="col-md-3 col-xs-3">
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
        <div class="col-md-4 col-xs-4">
            <?= Html::submitButton(
                '<i class="fa fa-search"></i> Xem báo cáo', 
                [
                    'class'=>'btn btn-primary btn-flat',
                    'id' => 'searchBtn',
                    
                ])
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?= $this->render('_table_data', [
        'data' => $data,
        'dongiamayno' => $dongiamayno,
    ]) ?>