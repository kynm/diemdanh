<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\widgets\Pjax;
use app\models\Nhanvien;
use app\models\User;
use yii\helpers\Url;
use app\models\Thuchienbd;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đợt '.$model->MA_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['index']];
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
                        if ($model->ID_NHANVIEN == Yii::$app->user->identity->nhanvien->ID_NHANVIEN || Yii::$app->user->identity->nhanvien->chucvu->cap == 2 || Yii::$app->user->identity->nhanvien->chucvu->cap == 3 || Yii::$app->user->can('Administrator') ) {
                            $canReview = true;
                            echo Html::a(
                                '<i class="glyphicon glyphicon-check"></i> Xác nhận tất cả', 
                                Url::to(['congviec/xacnhantatca', 'id' => $model->ID_DOTBD]),
                                ['class'=>'btn btn-primary btn-flat']
                            ) .' '; 

                            echo Html::a(
                                '<i class="glyphicon glyphicon-log-in"></i> Kết thúc bảo dưỡng', 
                                Url::to(['dotbaoduong/ketthuc', 'id' => $model->ID_DOTBD]),
                                ['class'=>'btn btn-primary btn-flat']
                            ) ;
                        }
                    ?>
                </p>

                <p class="form-inline">
                    <div class="form-group col-md-3 col-sm-6">
                        <label>Trạm viễn thông</label>
                        <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->tRAMVT->TEN_TRAM ; ?>">
                    </div>
                    <div class="form-group col-md-3 col-sm-6">
                        <label>Ngày bảo dưỡng</label>
                        <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->NGAY_BD ; ?>">
                    </div>
                    <div class="form-group col-md-3 col-sm-6">
                        <label>Nhóm trưởng</label>
                        <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->nHANVIEN->TEN_NHANVIEN ; ?>">
                    </div>
                    <div class="form-group col-md-3 col-sm-6">
                        <label>Trạng thái</label>
                        <input type="text" class="form-control" id="exp" disabled="true" value="Đang thực hiện">
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
                            if ($model->TRANGTHAI == 'Chờ xác nhận') {
                                return ['class' => 'warning'];
                            } elseif ($model->TRANGTHAI == 'Hoàn thành') {
                                return ['class' => 'success'];
                            } else {
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
                            'GHICHU',
                            [
                                'attribute' => 'ID_NHANVIEN',
                                'value' => 'nHANVIEN.TEN_NHANVIEN'
                            ],
                            [
                                'attribute' => 'xacnhan',
                                'format' => 'raw',
                                'visible' => $canReview,
                                'value' => function ($model) {
                                    if ($model->TRANGTHAI == 'Chờ xác nhận') {
                                        return Html::a(
                                            'Xác nhận', 
                                            Url::to(['congviec/xacnhan', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG]),
                                            ['class'=>'btn btn-primary btn-flat']
                                        ) ;
                                    } elseif ($model->TRANGTHAI == 'Hoàn thành') {
                                        return Html::a(
                                            'Hủy xác nhận', 
                                            Url::to(['congviec/huyxacnhan', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG]),
                                            ['class'=>'btn btn-primary btn-flat']
                                        ) ;
                                    } else {
                                        return Html::button(
                                            'Xác nhận', 
                                            [
                                                'class'=>'btn btn-primary btn-flat',
                                                'disabled' => true,
                                                'onclick' => 'alert("Công việc chưa hoàn thành. Không xác nhận được!")'
                                            ]
                                        ) ;
                                    }
                                }
                            ],
                        ],
                    ]); ?>
                <?php ActiveForm::end(); ?>
                
                <div class="row">
                    <?php foreach ($images as $image) {  ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <a href="<?= Yii::$app->homeUrl .'uploads/'.$image->ANH ?>" class="thumbnail">
                                <img src="<?= Yii::$app->homeUrl .'uploads/'.$image->ANH ?>" class="img-responsive">
                            </a>
                            <p class="text-center"> <?= $image->nHANVIEN->TEN_NHANVIEN ?> - <?= $image->type == 1 ? 'Tổ trưởng' : 'Nhân viên' ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>