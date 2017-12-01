<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
// use yii\widgets\DetailView;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use app\models\Thietbitram;
use app\models\Noidungbaotri;
use app\models\Nhanvien;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */

$this->title = $model->ID_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Dotbaoduongs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dotbaoduong-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="form-inline">
        <div class="form-group col-md-4">
            <label>Đợt bảo dưỡng</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->MA_DOTBD ; ?>">
        </div>
        <div class="form-group col-md-4">
            <label>Ngày bảo dưỡng</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->NGAY_BD ; ?>">
        </div>
        <div class="form-group col-md-4">
            <label>Nhóm trưởng</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->tRUONGNHOM->TEN_NHANVIEN ; ?>">
        </div>
    </p>

<?php
    $form = ActiveForm::begin();
    echo '<div class="text-right">'.
        Html::a(
            '<i class="glyphicon glyphicon-plus"></i> Thêm nội dung', 
            '#', 
            [
                'class'=>'btn btn-success',
                'id' => '#add'
            ]
        ) . '&nbsp;' . 
        Html::a(
            '<i class="glyphicon glyphicon-trash"></i> Xóa nội dung', 
            '#',
            ['class'=>'btn btn-danger']
        ) . '&nbsp;' .
        Html::a(
            '<i class="glyphicon glyphicon-remove"></i> Xóa đợt bảo dưỡng', 
            ['delete', 'id' => $model->ID_DOTBD], 
            [
                'class'=>'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]
        ) . '&nbsp;' .
        Html::submitButton(
            '<i class="glyphicon glyphicon-floppy-disk"></i> Lưu', 
            ['class'=>'btn btn-primary']
        )
        . '</div>' ;
    echo TabularForm::widget([
        'form' => $form,
        'dataProvider' => $dataProvider,
        'attributes' => [
            'ID_THIETBI' => [
                'type' => TabularForm::INPUT_DROPDOWN_LIST, 
                'items'=>ArrayHelper::map(Thietbitram::find()->all(), 'ID_THIETBI', 'iDLOAITB.TEN_THIETBI')
            ],
            'MA_NOIDUNG' => [
                'type' => TabularForm::INPUT_DROPDOWN_LIST, 
                'items'=>ArrayHelper::map(Noidungbaotri::find()->all(), 'MA_NOIDUNG', 'NOIDUNG')
            ],
            'ID_NHANVIEN' => [
                'type' => TabularForm::INPUT_DROPDOWN_LIST, 
                'items'=>ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN')
            ],
        ],
        'gridSettings' => [
            //'floatHeader' => true,
        ]     
    ]); 
    ActiveForm::end(); 
$this->registerJs("$('#add').on('click', function() { alert('Button clicked!'); });");


?>

</div>
