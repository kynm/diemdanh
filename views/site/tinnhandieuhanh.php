<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Donvi;
use app\models\Dichvu;
use kartik\select2\Select2;
$dsDonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', [2,3,4,5,6,7]])->all(), 'ID_DONVI', 'TEN_DONVI');
/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'Tin nhắn điều hành';
$this->params['breadcrumbs'][] = ['label' => 'Điều hành', 'url' => ['/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="baohong-create">

<div class="donvi-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3 col-xs-3">
                    <div class="form-group">
                        <?php foreach ($dsDonvi as $key => $value) {?>
                            <div class="checkbox">
                                <label><input type="checkbox" value="<?php echo $key?>" name="donvi_id[]" checked="checked"><?php echo $value?></label>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <div class="col-md-9 col-xs-9">
                    <div class="form-group field-election-election_description">
                    <label class="control-label" for="election-election_description">Nội dung</label>
                    <textarea id="election-election_description" class="form-control" name="noidung"></textarea>    
                    <div class="help-block"></div>
                    </div>
                </div>
            </div>
        </div>
            
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton('<i class="fa fa-plus"></i> Gửi tin nhắn', ['class' => 'btn btn-primary btn-flat', 'id' => 'submit-form']) ?>
            </div>
        </div>
    </div>







    <?php ActiveForm::end(); ?>

</div>

</div>
