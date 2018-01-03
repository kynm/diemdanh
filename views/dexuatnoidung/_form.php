<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Thietbi;
use app\models\Noidungbaotri;

/* @var $this yii\web\View */
/* @var $model app\models\Dexuatnoidung */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dexuatnoidung-form">

    <?php $form = ActiveForm::begin(); ?>

    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    <div class="col-md-6">    
        <?= $form->field($model, 'ID_LOAITB')->dropDownList(
            ArrayHelper::map(Thietbi::find()->all(), 'ID_THIETBI', 'TEN_THIETBI'),
            [
            	'prompt' => 'Chọn nhóm thiết bị',
                'onchange' => '
                    $.post("index.php?r=noidungbaotri/lists&id='.'"+$(this).val(), function( data ) {
                        $("#dynamicmodel-ma_noidung").html( data );
                    });'
            ])
            ->label(Yii::t('app','Loại thiết bị')) 
        ?>
        <?= $form->field($model, 'LAN_BD')->dropDownList(array_combine(range(1, 15), range(1, 15)), ['prompt' => 'Chọn lần bảo dưỡng'])->label(Yii::t('app','Lần bảo dưỡng')) ?>        

        <?= $form->field($model, 'CHUKYBAODUONG')->textInput(['maxlength' => true])->label(Yii::t('app','Chu kỳ bảo dưỡng')) ?>    
    </div>
    

    <div class="col-md-6 panel" style="height: 300px;overflow-y: scroll;background: #e7e7e8!important;">
        <?= $form->field($model, 'MA_NOIDUNG')->checkboxList(ArrayHelper::map(Noidungbaotri::find()->all(), 'MA_NOIDUNG', 'NOIDUNG'),
            [
                'separator' => '<br>'
            ])->label(Yii::t('app','Mã nội dung'));
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
