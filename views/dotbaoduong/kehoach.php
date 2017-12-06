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
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */

$this->title = 'Đợt bảo dưỡng '.$model->MA_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Dotbaoduongs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dotbaoduong-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="form-inline">
        <div class="form-group col-md-4">
            <label>Trạm viễn thông</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->iDTRAMVT->MA_TRAM ; ?>">
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
    
    ?>
    <div class="form-group col-md-4">
    <?= $form->field($kehoachModel, 'ID_THIETBI')->dropDownList(
        ArrayHelper::map(Thietbitram::find()->where(['ID_TRAM' => $model->ID_TRAMVT])->all(), 'ID_THIETBI', 'iDLOAITB.TEN_THIETBI'),
        [
            'prompt' => 'Chọn thiết bị',
            'onchange' => '
                $.post("index.php?r=noidungbaotri/liststbt&id='.'"+$(this).val(), function( data ) {
                    $("#kehoachbdtb-ma_noidung").html( data );
                });
            ',
        ])
    ?>
    </div>
    <div class="form-group col-md-4">
    <?= $form->field($kehoachModel, 'MA_NOIDUNG')->dropDownList(
        ArrayHelper::map(Noidungbaotri::find()->all(), 'MA_NOIDUNG', 'NOIDUNG'),
        [
            'prompt' => 'Chọn nội dung bảo dưỡng',
            
        ])
    ?>
    </div>
    <div class="form-group col-md-4">
    <?= $form->field($kehoachModel, 'ID_NHANVIEN')->dropDownList(
        ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
        [
            'prompt' => 'Chọn nhân viên bảo dưỡng',
        ])
    ?>
    </div>
<?php
    echo '<div class="text-right">'.
        Html::a(
            '<i class="glyphicon glyphicon-plus"></i> Thêm nội dung', 
            '#', 
            [
                'class'=>'btn btn-success',
                'id' => '#addBtn',
                'onclick' => '
                    $.post("index.php?r=kehoachbdtb/create&ID_DOTBD='.$model->ID_DOTBD.'&ID_THIETBI='.$kehoachModel->ID_THIETBI.'&MA_NOIDUNG='.$kehoachModel->MA_NOIDUNG.'&ID_NHANVIEN='.$kehoachModel->ID_NHANVIEN.', 
                        function() {
                            
                    });
                '
            ]
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
                'items'=>ArrayHelper::map(Thietbitram::find()->all(), 'ID_THIETBI', 'iDLOAITB.TEN_THIETBI'),
                // 'onchange' => '
                //     $.post("index.php?r=noidungbaotri/lists&id='.'"+$(this).val(), function( data ) {
                //         $("#dynamicmodel-ma_noidung").html( data );
                //     });
                // '
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
        ],
        'serialColumn' => false,
        'checkboxColumn' => false,
        'actionColumn' => [
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'data-method' => 'post',
                            'onclick' => '
                                $(this).parents("tr").remove();

                            '
                        ]);
                }
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'delete') {
                    $url = '';
                    $url ='index.php?r=kehoachbdtb/delete&ID_DOTBD='.$model->ID_DOTBD.'&ID_THIETBI='.$model->ID_THIETBI.'&MA_NOIDUNG='.$model->MA_NOIDUNG;
                    return $url;
                }
            }
        ],
    ]); 
    ActiveForm::end(); 
?>

</div>
