<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use app\models\Thietbitram;
use app\models\Dotbaoduong;
use app\models\Noidungcongviec;
use app\models\Noidungbaotri;
use app\models\Nhanvien;
use yii\web\View;
use yii\grid\CheckboxColumn;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */

$this->title = 'Đợt '.$model->MA_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['danhsachkehoach']];
$this->params['breadcrumbs'][] = ['label' => 'Kế hoạch', 'url' => ['danhsachkehoach']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dotbaoduong-view">

    <div class="box box-primary">
        <div class="box-body">
            <?php
                $form = ActiveForm::begin();
                if (Yii::$app->user->identity->nhanvien->ID_NHANVIEN == $model->TRUONG_NHOM) {
                    echo 
                        Html::a(
                            '<i class="glyphicon glyphicon-wrench"></i> Thực hiện bảo dưỡng', 
                            ['thuchien', 'id' => $model->ID_DOTBD], 
                            [
                                'class'=>'btn btn-primary btn-flat',
                                'data' => [
                                    'confirm' => 'Bạn muốn thực hiện đợt bảo dưỡng?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                } 
            ?>
            <p class="form-inline">
                <div class="form-group col-md-3">
                    <label>Trạm viễn thông</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->tRAMVT->MA_TRAM ; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Ngày bảo dưỡng</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->NGAY_BD ; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Nhóm trưởng</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->tRUONGNHOM->TEN_NHANVIEN ; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>Trạng thái</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->TRANGTHAI ; ?>">
                </div>
            </p>
            
            <?php                
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'ID_THIETBI',
                            'value' => 'tHIETBI.iDLOAITB.TEN_THIETBI'
                        ],
                        [
                            'attribute' => 'MA_NOIDUNG',
                            'value' => 'mANOIDUNG.NOIDUNG'
                        ],
                        [
                            'attribute' => 'ID_NHANVIEN',
                            'value' => 'nHANVIEN.TEN_NHANVIEN'
                        ],
                        
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    if (Yii::$app->user->can('edit-dbd')) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                                    } else {
                                        return '';
                                    }    
                                }

                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'delete') {
                                    $url = '';
                                    $url = ['noidungcongviec/delete', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG, 'ID_NHANVIEN' => $model->ID_NHANVIEN]; 
                                    return $url;
                                }
                            }
                        ],
                    ],
                ]);

                ActiveForm::end(); 
            ?>
        </div>
    </div>

</div>