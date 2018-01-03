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

    <?= $form->field($model, 'ID_LOAITB')->dropDownList(
        ArrayHelper::map(Thietbi::find()->all(), 'ID_THIETBI', 'TEN_THIETBI'),
        [
        	'prompt' => 'Chọn nhóm thiết bị',
        	'onchange' => '
        		$.post("index.php?r=noidungbaotri/lists&id='.'"+$(this).val(), function( data ) {
        			$("#dexuatnoidung-ma_noidung").html( data );
        		});'
        ]) 
    ?>

    <?= $form->field($model, 'LAN_BD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CHUKYBAODUONG')->textInput(['maxlength' => true]) ?>

    <?php
    	$noidung = ArrayHelper::map(Noidungbaotri::find()->all(), 'MA_NOIDUNG', 'NOIDUNG');
    ?>

    <?= $form->field($model, 'MA_NOIDUNG')->checkboxList($noidung);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
 
var id_thietbi = 0;
$("select").change(function() {
    id_thietbi = $(this).val()
 
    $('input[type=checkbox]').each(function () {
        $(this).prop('checked', false);
    });
 
    $.ajax({
        url: 'index.php?r=dexuatnoidung/get-noidungs&id='+id_thietbi,
        dataType: "json",
        success: function(data) {
          $.each(data, function(key, value){
            $('input[type=checkbox]').each(function () {
                if($(this).val()==key){
                  $(this).prop('checked', true);
                }
            });
          });
        }
    })
});
 
$("input[type=checkbox]").change(function() {
    if(this.checked) {
        var lanbd = $("input#dynamicmodel-lan_bd").val();
        var chuky = $("input#dynamicmodel-chukybaoduong").val();

        $.post("index.php?r=dexuatnoidung/set-noidung&ID_THIETBI="+id_thietbi+"&MA_NOIDUNG="+$(this).val()+"&LAN_BD="+lanbd+"&CHUKYBAODUONG="+chuky)
    }
    else{
      $.post("index.php?r=dexuatnoidung/unset-noidung&ID_THIETBI="+id_thietbi+"&MA_NOIDUNG="+$(this).val())
    }
});
 
JS;
$this->registerJs($script);