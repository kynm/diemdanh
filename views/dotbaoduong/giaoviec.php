<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Tramvt;
use app\models\Thietbitram;
use app\models\Noidungcongviec;
use app\models\Nhanvien;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Giao việc';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giaoviec-index">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <p class="form-inline">
                <div class="form-group col-md-4">
                    <label>Trạm viễn thông</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->tRAMVT->MA_TRAM ; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Ngày bảo dưỡng</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->NGAY_BD ; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Nhóm trưởng</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->tRUONGNHOM->TEN_NHANVIEN ; ?>">
                </div>
            </p>
            <?php Pjax::begin(); ?>
            
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <strong>Tất cả nội dung</strong>
                    </div>
                    <div class="box-body">
                          
                        <?= GridView::widget([
                            'dataProvider' => $selectedDataProvider,
                            // 'showHeader' => true,
                            'layout' => "{items}{pager}",
                            'emptyText' => false,
                            'columns' => [
                                ['class' => 'yii\grid\CheckboxColumn',
                                    'name' => 'AddSelection'
                                ],
                                [
                                    'attribute' => 'MA_NOIDUNG',
                                    'value' => 'mANOIDUNG.NOIDUNG',
                                ],
                            ],
                        ]) ?>
                        
                    </div>
                </div>
            </div>
            <div class="form-group col-md-2">
                    <?php
                        $nhanvien = new \yii\base\DynamicModel(['ID_NHANVIEN']);
                        $nhanvien->addRule(['ID_NHANVIEN'], 'integer');
                    ?>
                    <?= $form->field($nhanvien, 'ID_NHANVIEN')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
                            'options' => ['placeholder' => 'Chọn nhân viên'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false); ?>
                    <?= Html::button(
                        'Thêm <i class="fa fa-angle-double-right"></i>', 
                        [
                            'class'=>'btn btn-primary btn-flat btn-block',
                            'id' => 'addBtn',
                            'onclick' => '
                                var keys = $("#w1").yiiGridView("getSelectedRows");
                                $.pjax.reload({ 
                                    container: "#p0",
                                    url: "'.Url::to(['dotbaoduong/giaoviec', 'id' => $model->ID_DOTBD]).'", 
                                    data: {
                                        addkeylist: keys,
                                        idnhanvien : $("#dynamicmodel-id_nhanvien").val(),
                                    }
                                }); 
                            '
                        ]
                    )?>
                    <?= Html::button(
                        '<i class="fa fa-angle-double-left"></i> Xóa', 
                        [
                            'class'=>'btn btn-danger btn-flat btn-block',
                            'id' => 'rmvBtn',
                            'onclick' => '
                                var keys = $("#w2").yiiGridView("getSelectedRows");
                                $.pjax.reload({ 
                                    container: "#p0",
                                    url: "'.Url::to(['dotbaoduong/giaoviec', 'id' => $model->ID_DOTBD]).'", 
                                    data: {
                                        rmvkeylist: keys
                                    }
                                }); 
                            '
                        ]
                    )?>               
            </div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <strong>Nội dung được chọn</strong>
                    </div>
                    <div class="box-body">
                        <div id="dsnoidung"></div>
                         
                        <?= GridView::widget([
                            'dataProvider' => $taskDataProvider,
                            // 'showHeader' => false,
                            'layout' => "{items}\n{pager}",
                            'emptyText' => false,
                            'columns' => [
                                ['class' => 'yii\grid\CheckboxColumn',
                                    'name' => 'AddSelection'
                                ],
                                [
                                    'attribute' => 'MA_NOIDUNG',
                                    'value' => 'mANOIDUNG.NOIDUNG',
                                ],
                                [
                                    'attribute' => 'ID_NHANVIEN',
                                    'value' => 'nHANVIEN.TEN_NHANVIEN',
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::a(
                    '<i class="fa fa-angle-double-left"></i> Quay lại', 
                    ['lencongviec', 'id' => $model->ID_DOTBD],
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'prevBtn',
                    ]
                )?>
                <?= Html::a(
                    'Hoàn thành <i class="fa fa-angle-double-right"></i>',
                    ['view', 'id' => $model->ID_DOTBD],
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'nextBtn',
                    ]
                )?> 
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>