<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Tramvt;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */
/* @var $form yii\widgets\ActiveForm */

switch (Yii::$app->user->identity->nhanvien->chucvu->cap) {
    case '1':
        $listTram = ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'TEN_TRAM');
        break;
    case '2':
        $listTram = ArrayHelper::map(Tramvt::find()->joinWith('iDDAI')->where(['daivt.ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_TRAM', 'TEN_TRAM');
        break;
    case '3':
        $listTram = ArrayHelper::map(Tramvt::find()->where(['ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI])->all(), 'ID_TRAM', 'TEN_TRAM');
        break;
    case '4':
        $listTram = ArrayHelper::map(Tramvt::find()->where(['ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN])->all(), 'ID_TRAM', 'TEN_TRAM');
        break;
    case '5': //Tạm thời để giống cấp 3
        $listTram = ArrayHelper::map(Tramvt::find()->where(['ID_DAI' => Yii::$app->user->identity->nhanvien->ID_DAI])->all(), 'ID_TRAM', 'TEN_TRAM');
        break;
    
    default:
        break;
}
?>

<div class="dotbaoduong-form">
    
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'MA_DOTBD')->textInput(['maxlength' => true]) ?>
                </div>
                    
                <div class="col-sm-4">
                    <?= $form->field($model, 'ID_TRAM')->widget(Select2::classname(), [
                        'data' => $listTram,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn trạm',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div>

                <div class="col-sm-4">
                    <?= $form->field($model, 'ID_NHANVIEN')->widget(Select2::classname(), [
                        'data' => $listNhanvien,
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn nhóm trưởng',
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-sm-6">
                    <label class="control-label">Ngày bắt đầu dự kiến</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAY_DUKIEN',
                        'name' => 'ngaybd', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Dự kiến ...'],
                        'pluginOptions' => [

                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                    
                <div class="col-sm-6">
                    <label class="control-label">Ngày kết thúc dự kiến</label>
                    <?= DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'NGAY_KT_DUKIEN',
                        'name' => 'ngaykt', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Dự kiến ...'],
                        'pluginOptions' => [

                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
            </div>                
        </div>
                
        <div class="box-footer">
            <div class="text-center">
                <?= $model->isNewRecord ? '' :Html::submitButton(
                    '<i class="fa fa-pencil-square-o"></i> Cập nhật', 
                    ['class' => 'btn btn-primary btn-flat']
                )?>
                
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
