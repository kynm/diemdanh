<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Thietbi;
use app\models\Tramvt;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbitram */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thietbitram-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'ID_LOAITB')->dropDownList(
        ArrayHelper::map(Thietbi::find()->all(), 'ID_THIETBI', 'TEN_THIETBI'),
        ['prompt' => 'Chọn loại thiết bị']
    ) ?>

    <?= $form->field($model, 'ID_TRAM')->dropDownList(
        ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'MA_TRAM'),
        ['prompt' => 'Chọn trạm']
    ) ?>

    <?= $form->field($model, 'SERIAL_MAC')->textInput() ?>

    <div class="row" style="margin-bottom: 8px">
        <div class="col-sm-4 col-md-4">
            <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'NGAYSX',
                'name' => 'ngaysx', 
                'removeButton' => false,
                'options' => ['placeholder' => 'Ngày sản xuất ...'],
                'pluginOptions' => [

                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]); ?>
        </div>
        <div class="col-sm-4 col-md-4">
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'NGAYSD',
                    'name' => 'ngaysd', 
                    'removeButton' => false,
                    'options' => ['placeholder' => 'Ngày đưa vào sử dụng ...'],
                    'pluginOptions' => [

                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]); ?>
        </div>
        <div class="col-sm-4 col-md-4">
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'LANBAODUONGTRUOC',
                    'name' => 'ngaybd', 
                    'removeButton' => false,
                    'options' => ['placeholder' => 'Lần bảo dưỡng gần đây ...'],
                    'pluginOptions' => [

                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]); ?>
        </div>
    </div>

    <?= $form->field($model, 'LANBD')->textInput() ?>

    <?php ActiveForm::end(); ?>

</div>
