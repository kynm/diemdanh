<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Dotbaoduong;
use app\models\Nhanvien;
use app\models\Noidungbaotri;
use app\models\Thietbitram;
use kartik\builder\Form;
use kartik\grid\GridView;
use kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Kehoachbdtb */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kehoachbdtb-form">

    <?php $form = ActiveForm::begin(); ?>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

    <?= $form->field($model, 'ID_DOTBD')->dropDownList(
        ArrayHelper::map(Dotbaoduong::find()->all(), 'ID_DOTBD', 'MA_DOTBD'),
        [
        	'prompt' => 'Chọn đợt bảo dưỡng',
            'onchange' => '
                $.post("index.php?r=thietbitram/lists&id='.'"+$(this).val(), function( data ) {
                    $("#kehoachbdtb-id_thietbi").html( data );
                });'
        ])
    ?>

    <?= $form->field($model, 'ID_THIETBI')->dropDownList(
        ArrayHelper::map(Thietbitram::find()->all(), 'ID_THIETBI', 'iDLOAITB.TEN_THIETBI'),
        [
        	'prompt' => 'Chọn thiết bị',
            'onchange' => '
	            $.post("index.php?r=noidungbaotri/liststbt&id='.'"+$(this).val(), function( data ) {
	                $("#kehoachbdtb-ma_noidung").html( data );
	            });
	        '
        ])
    ?>

    <?= $form->field($model, 'MA_NOIDUNG')->dropDownList(
        ArrayHelper::map(Noidungbaotri::find()->all(), 'MA_NOIDUNG', 'NOIDUNG'),
        [
        	'prompt' => 'Chọn nội dung bảo dưỡng',
        ])
    ?>

    <?= $form->field($model, 'ID_NHANVIEN')->dropDownList(
        ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
        [
        	'prompt' => 'Chọn nhân viên bảo dưỡng',
        ])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

  