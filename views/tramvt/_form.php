<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Daivt;
use app\models\Nhanvien;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
/* @var $form yii\widgets\ActiveForm */

switch (Yii::$app->user->identity->nhanvien->chucvu->cap) {
    case '1':
        $listDaivt = ArrayHelper::map(Daivt::find()->all(), 'ID_DAI', 'TEN_DAIVT');
        break;
    case '2':
        $listDaivt = ArrayHelper::map(Daivt::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_DAI', 'TEN_DAIVT');
        break;
    case '3':
        $listDaivt = ArrayHelper::map(Daivt::find()->where(['ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI])->all(), 'ID_DAI', 'TEN_DAIVT');
        break;
    default:
        $listDaivt = [];
        break;
}

?>

<div class="tramvt-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-6">
                <?= $form->field($model, 'MA_TRAM')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-6">
                <?= $form->field($model, 'TEN_TRAM')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-6">
                <?= $form->field($model, 'DIADIEM')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-6">
                <?= $form->field($model, 'LOAITRAM')->dropDownList([1 => 'Indoor', 2 => 'Outdoor',]) ?>
            </div>
                
            <div class="col-sm-6">
            	<?= $form->field($model, 'ID_DAI')->widget(Select2::classname(), [
                    'data' => $listDaivt,
                    'options' => ['placeholder' => 'Chọn đài quản lý'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
                
            <div class="col-sm-6">
                <?= $form->field($model, 'ID_NHANVIEN')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Nhanvien::find()->where(['>', 'ID_NHANVIEN', 0])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
                    'options' => ['placeholder' => 'Chọn nhân viên quản lý'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>

            <div class="col-sm-6">
                <?= $form->field($model, 'KINH_DO')->textInput(['maxlength' => true, 'type' => 'number', 'step' => 'any', 'disabled' => ! Yii::$app->user->can('Administrator')]) ?>
            </div>
                
            <div class="col-sm-6">
                <?= $form->field($model, 'VI_DO')->textInput(['maxlength' => true, 'type' => 'number', 'step' => 'any', 'disabled' => ! Yii::$app->user->can('Administrator')]) ?>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
        </div>
    </div>
            
    <?php ActiveForm::end(); ?>

</div>
