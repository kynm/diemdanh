<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Daivt;
use app\models\Nhanvien;
use app\models\TrangthaiCSHT;
use app\models\LoaihinhCSHT;
use app\models\KieuCSHT;
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
$listtrangthai = ArrayHelper::map(TrangthaiCSHT::find()->all(), 'ID', 'TEN_TRANGTHAI_CSHT');
$listloaihinh = ArrayHelper::map(LoaihinhCSHT::find()->all(), 'ID', 'TEN_LOAIHINH_CSHT');
$listkieu = ArrayHelper::map(KieuCSHT::find()->all(), 'ID', 'TEN_KIEU_CSHT');

?>

<div class="tramvt-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-2">
                <?= $form->field($model, 'MA_TRAM')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-2">
                <?= $form->field($model, 'TEN_TRAM')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($model, 'DIADIEM')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'MA_CSHT')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'MA_HD_CSHT')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-2">
                <?= $form->field($model, 'LOAITRAM')->dropDownList($listloaihinh) ?>
            </div>
                
            <div class="col-sm-2">
            	<?= $form->field($model, 'ID_DAI')->widget(Select2::classname(), [
                    'data' => $listDaivt,
                    'options' => ['placeholder' => 'Chọn đài quản lý'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'TRANGTHAI_CSHT_ID')->widget(Select2::classname(), [
                    'data' => $listtrangthai,
                    'options' => ['placeholder' => 'Chọn trạng thái'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
                
            <div class="col-sm-2">
                <?= $form->field($model, 'ID_NHANVIEN')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Nhanvien::find()->where(['>', 'ID_NHANVIEN', 0])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
                    'options' => ['placeholder' => 'Chọn nhân viên quản lý'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'KIEUTRAM')->widget(Select2::classname(), [
                    'data' => $listkieu,
                    'options' => ['placeholder' => 'Kiểu trạm'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>

            <div class="col-sm-2">
                <?= $form->field($model, 'KINH_DO')->textInput(['maxlength' => true, 'type' => 'number', 'step' => 'any', 'disabled' => ! Yii::$app->user->can('Administrator')]) ?>
            </div>
                
            <div class="col-sm-2">
                <?= $form->field($model, 'VI_DO')->textInput(['maxlength' => true, 'type' => 'number', 'step' => 'any', 'disabled' => ! Yii::$app->user->can('Administrator')]) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'MA_DIENLUC')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="box-footer col-sm-12">
                <div class="text-center">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
                </div>
            </div>
    </div>
            
    <?php ActiveForm::end(); ?>

</div>
