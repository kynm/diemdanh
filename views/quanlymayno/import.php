<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Daivt;
use app\models\Nhanvien;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
$this->title = 'Đẩy dữ liệu điện';
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
    <p>
        <?= (Yii::$app->user->can('import-qldien')) ? Html::a('<i class="fa fa-plus"></i> Tải file mẫu', 'https://drive.google.com/file/d/1aimVmS5dZAtJMU_dX5snZB59oDsUqNWM/view?usp=sharing', ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) : '' ?>
    </p>
<div class="tramvt-update">
<div class="import-dien-form">
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'options' => ['enctype' => 'multipart/form-data'],
        // 'action' => 'vnpt_mds/quanlydien/import',
    ]); ?>
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-md-2 col-xs-2">
                    <?= $form->field($model, 'MA_DONVIKT')->dropDownList($dsdonvi, ['prompt' => 'Chọn đơn vị' ]); ?>
                </div>
                <div class="col-md-2 col-xs-2">
                    <?= $form->field($model, 'THANG')->dropDownList($months, ['prompt' => 'Chọn tháng' ]); ?>
                </div>
                <div class="col-md-2 col-xs-2">
                    <?= $form->field($model, 'NAM')->dropDownList($years, ['prompt' => 'Chọn năm' ]); ?>
                </div>
                <div class="col-md-2 col-xs-2">
                    <?= $form->field($model, 'fileupload')->fileInput();?>
                </div>
            </div>
            <div class="col-md-2 col-xs-2">
                <?= Html::submitButton(
                    '<i class="fa fa-search"></i> Import', 
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'searchBtn',
                        
                    ])
                ?>
            </div>
        </div>     
        
        <?php ActiveForm::end(); ?>
</div>

</div>