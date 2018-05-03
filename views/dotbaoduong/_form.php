<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Tramvt;
use app\models\Nhanvien;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */
/* @var $form yii\widgets\ActiveForm */

switch (Yii::$app->user->identity->nhanvien->chucvu->cap) {
    case '1':
        $listTram = ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'MA_TRAM');
        break;
    case '2':
        $listTram = ArrayHelper::map(Tramvt::find()->joinWith('iDDAI')->where(['daivt.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_TRAM', 'MA_TRAM');
        break;
    case '3':
        $listTram = ArrayHelper::map(Tramvt::find()->where(['ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI])->all(), 'ID_TRAM', 'MA_TRAM');
        break;
    case '4':
        $listTram = ArrayHelper::map(Tramvt::find()->where(['ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN])->all(), 'ID_TRAM', 'MA_TRAM');
        break;
    case '5': //Tạm thời để giống cấp 3
        $listTram = ArrayHelper::map(Tramvt::find()->where(['ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI])->all(), 'ID_TRAM', 'MA_TRAM');
        break;
    
    default:
        break;
}
?>

<div class="dotbaoduong-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-header">
            <div class="col-sm-12">
                <?= $model->isNewRecord ? '' :Html::submitButton('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'MA_DOTBD')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-sm-6">
                    <?= $form->field($model, 'ID_TRAMVT')->dropDownList($listTram);
                    ?>
                </div>
            </div>
                
            <div class="row">
                <div class="col-sm-6">
                    <label class="control-label">Ngày bảo dưỡng</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAY_BD',
                        'name' => 'ngaybd', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Ngày bảo dưỡng ...'],
                        'pluginOptions' => [

                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                    
                <div class="col-sm-6">
                    <?= $form->field($model, 'TRUONG_NHOM')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
                        'options' => ['placeholder' => 'Chọn nhóm trưởng'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            </div>                
        </div>
                
        <div class="box-footer">
            <div class="text-center">
                <?= Html::a(
                    '<i class="fa fa-remove"></i> Hủy',
                    ['danhsachkehoach'], 
                    [
                        'class'=>'btn btn-danger btn-flat',
                        'id' => 'cancelBtn',
                        'style' => 'width: 92.156px'
                    ]
                )?>
                <?= $model->isNewRecord ? Html::submitButton(
                    'Tiếp theo <i class="fa fa-angle-double-right"></i>',
                    // ['lencongviec', 'id' => $model->ID_DOTBD],
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'nextBtn',
                    ]) : Html::a(
                    'Tiếp theo <i class="fa fa-angle-double-right"></i>',
                    ['lencongviec', 'id' => $model->ID_DOTBD],
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'nextBtn',
                    ]) ?>
                
            </div>
        </div>
    </div>






    <?php ActiveForm::end(); ?>

</div>
