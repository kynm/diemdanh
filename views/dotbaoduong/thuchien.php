<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\widgets\Pjax;
use app\models\Nhanvien;
use app\models\User;
use app\models\Thuchienbd;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đợt '.$model->MA_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['danhsachkehoach']];
$this->params['breadcrumbs'][] = ['label' => 'Thực hiện', 'url' => ['danhsachthuchien']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dotbaoduong-index">
    <div class="">
        <div class="box box-primary">
            <div class="box-body">
                <p> 
                    <?php $form = ActiveForm::begin(); ?>
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                    <?php
                        @$nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
                        $canReview = 0;
                        if ($model->TRUONG_NHOM == @$nhanvien->ID_NHANVIEN) {
                            $canReview = 1;
                            echo Html::submitButton(
                                '<i class="glyphicon glyphicon-log-in"></i> Kết thúc bảo dưỡng', 
                                ['class'=>'btn btn-primary btn-flat']
                            ) ;                    
                            
                        }
                    ?>
                </p>

                <p class="form-inline">
                    <div class="form-group col-md-3 col-sm-6">
                        <label>Trạm viễn thông</label>
                        <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->tRAMVT->MA_TRAM ; ?>">
                    </div>
                    <div class="form-group col-md-3 col-sm-6">
                        <label>Ngày bảo dưỡng</label>
                        <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->NGAY_BD ; ?>">
                    </div>
                    <div class="form-group col-md-3 col-sm-6">
                        <label>Nhóm trưởng</label>
                        <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->tRUONGNHOM->TEN_NHANVIEN ; ?>">
                    </div>
                    <div class="form-group col-md-3 col-sm-6">
                        <label>Trạng thái</label>
                        <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->TRANGTHAI ; ?>">
                    </div>
                </p>

                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'formatter' => [
                            'class' => 'yii\i18n\Formatter',
                            'nullDisplay' => '',
                        ],
                        'rowOptions' => function ($model) {
                            if ($model->TRANGTHAI == 'Chưa hoàn thành') {
                                return ['class' => 'danger'];
                            }
                        },
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
                            'TRANGTHAI',
                            [
                                'class' => 'kartik\grid\EditableColumn',
                                'attribute' => 'ID_THIETBI', 
                                'header' => '&nbsp;',
                                'width'=>'0px',
                                'hidden' => true,
                                'content' => function($data){
                                    return '&nbsp;';
                                },
                                'editableOptions'=>['header'=>'Name', 'size'=>'sm'],
                            ],
                            [
                                'class' => 'kartik\grid\EditableColumn',
                                'attribute' => 'GHICHU', 
                                'hAlign' => 'right', 
                                'vAlign' => 'middle',
                                'width' => '7%',
                                'editableOptions' => [
                                    'disabled' => $canReview == 1 ? false : true,
                                ],
                            ],
                            [
                                'attribute' => 'ID_NHANVIEN',
                                'value' => 'nHANVIEN.TEN_NHANVIEN'
                            ],


                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'visible' => $canReview == 1 ? true : false,
                                'checkboxOptions' =>function($model) {
                                    return ['checked' => $model->TRANGTHAI == 'Hoàn thành' ? true : false ];
                                }
                            ],
                        ],
                    ]); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>