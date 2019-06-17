<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Thietbi;
use app\models\Tramvt;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbitram */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thietbitram-form">
    <div class="box box-primary">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?= $form->field($model, 'ID_LOAITB')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Thietbi::find()->all(), 'ID_THIETBI', 'TEN_THIETBI'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn loại thiết bị',
                            'allowClear' => true
                        ],
                    ]); ?>        
                </div>
                    
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?= $form->field($model, 'SERIAL_MAC')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?= $model->isNewRecord ? $form->field($model, 'ID_TRAM')->dropDownList(
                        ArrayHelper::map(Tramvt::find()->where(['ID_TRAM' => @$_GET['id_tram']])->all(), 'ID_TRAM', 'TEN_TRAM'),
                        [
                            'options' => [@$_GET['id_tram'] => ['Selected'=>'selected']],
                            'prompt' => 'Chọn trạm'
                        ]) : $form->field($model, 'ID_TRAM')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'TEN_TRAM'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn trạm',
                            'allowClear' => true,
                            'disabled' => true
                        ],
                    ]); ?>
                </div>
            
                <div class="col-sm-4 col-md-4">
                    <label>Ngày sản xuất</label>
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
                    <label>Ngày sử dụng</label>
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
                    <label>Ngày bảo dưỡng trước</label>
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
                <div id="message-nsx" class="col-sm-12"></div>
                <div id="message-nsd" class="col-sm-12"></div>
                <div id="message-nbd" class="col-sm-12"></div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?= $form->field($model, 'VB')->textArea(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS

    $("#thietbitram-ngaysx, #thietbitram-ngaysd, #thietbitram-lanbaoduongtruoc").on('change', function () {
        ngaysx = $('#thietbitram-ngaysx').val();
        ngaysx = new Date(ngaysx);
        ngaysd = $('#thietbitram-ngaysd').val();
        ngaysd = new Date(ngaysd);
        lanbaoduongtruoc = $('#thietbitram-lanbaoduongtruoc').val();
        lanbaoduongtruoc = new Date(lanbaoduongtruoc);
        today = new Date();
        if (ngaysx > today) {
            $('#message-nsx').html('Ngày sản xuất không đúng!!!').css('color', 'red');
        } else {
            $('#message-nsx').html('');
        }


        if (ngaysd < ngaysx) {
            $('#message-nsd').html('Ngày sản xuất phải trước ngày sử dụng!!!').css('color', 'red');
        } else if (ngaysd > today) {
            $('#message-nsd').html('Ngày đưa vào sử dụng không đúng!!!').css('color', 'red');
        } else {
            $('#message-nsd').html('');
        }


        if (lanbaoduongtruoc < ngaysd) {
            $('#message-nbd').html('Ngày bảo dưỡng phải sau ngày sử dụng!!!').css('color', 'red');
        }
        if (lanbaoduongtruoc > today) {
            $('#message-nbd').html('Ngày bảo dưỡng gần đây không đúng!!!').css('color', 'red');
        } 
        if (lanbaoduongtruoc > ngaysd && lanbaoduongtruoc < today) {
            $('#message-nbd').html('');
        }
    });


JS;
$this->registerJs($script);
?>