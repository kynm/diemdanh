<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Tramvt;
use app\models\Thietbitram;
use app\models\Noidungcongviec;
use app\models\Nhanvien;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lên kế hoạch';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lenkehoach-index">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <p class="form-inline">
                <div class="form-group col-md-4">
                    <label>Trạm viễn thông</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->tRAMVT->TEN_TRAM ; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Ngày bảo dưỡng</label>
                    <input type="text" class="form-control" disabled="true" value="<?= date('d-m-Y', strtotime($model->NGAY_DUKIEN)) ; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Nhóm trưởng</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->nHANVIEN->TEN_NHANVIEN ; ?>">
                </div>
            </p>
            <?php Pjax::begin(); ?>
            <div class="col-md-3">
                <?php
                    $congviec = new Noidungcongviec();
                    echo $form->field($congviec, 'ID_THIETBI')->dropDownList(ArrayHelper::map(Thietbitram::find()->where(['ID_TRAM' => $model->ID_TRAM ])->all(), 'ID_THIETBI', 'iDLOAITB.TEN_THIETBI'),
                        [
                            'prompt' => 'Chọn thiết bị',
                            'onchange' => '
                                $.pjax.reload({
                                    container: "#p0",
                                    url: "'. Url::to(["dotbaoduong/lencongviec", "id" => $model->ID_DOTBD]).'",
                                    data: {
                                        idthietbi : $(this).val()
                                    }
                                });
                            ',
                            'value' => @$_GET['idthietbi']
                        ] )->label(false);
                ?>
                
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <strong>Thông tin</strong>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            Thiết bị sử dụng trong: 
                            <strong><?= @$infoData['months'] ?></strong> tháng
                        </div>
                        <hr>
                        <?= GridView::widget([
                            'dataProvider' => $dexuatProvider,
                            'showHeader' => false,
                            'layout' => "{items}{pager}",
                            'emptyText' => false,
                            'columns' => [
                                [
                                    'attribute' => 'MA_NOIDUNG',
                                    'value' => 'mANOIDUNG.NOIDUNG',
                                ],
                            ],
                        ]) ?>

                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <strong>Nội dung bảo dưỡng</strong>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $allDataProvider,
                                // 'showHeader' => true,
                                'layout' => "{items}{pager}",
                                'emptyText' => false,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\CheckboxColumn',
                                        'name' => 'AddSelection',
                                        'checkboxOptions' =>function($model) {
                                            return ['checked' => $model->IS_SUGGESTED];
                                        }
                                    ],
                                    [
                                        'attribute' => 'MA_NOIDUNG',
                                        'value' => 'mANOIDUNG.NOIDUNG',
                                    ],
                                    [
                                        'attribute' => 'CHUKY',
                                        'value' => function ($model) {
                                            return $model->mANOIDUNG->CHUKY . ' tháng';
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-1">
                
                    <?= Html::button(
                        'Thêm <i class="fa fa-angle-double-right"></i>', 
                        [
                            'class'=>'btn btn-primary btn-flat btn-block',
                            'id' => 'addBtn',
                            'onclick' => '
                                var keys = $("#w2").yiiGridView("getSelectedRows");
                                $.pjax.reload({ 
                                    container: "#p0",
                                    url: " '. Url::to(['dotbaoduong/lencongviec', 'id' => $model->ID_DOTBD]) .' ", 
                                    data: {
                                        addkeylist: keys,
                                        idthietbi : $("#noidungcongviec-id_thietbi").val(),
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
                                var keys = $("#w3").yiiGridView("getSelectedRows");
                                $.pjax.reload({ 
                                    container: "#p0",
                                    url: " '. Url::to(['dotbaoduong/lencongviec', 'id' => $model->ID_DOTBD]) .' ", 
                                    data: {
                                        rmvkeylist: keys,
                                        idthietbi : $("#noidungcongviec-id_thietbi").val(),
                                    }
                                }); 
                            '
                        ]
                    )?>
                
            </div>
            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <strong>Nội dung được chọn</strong>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $selectedDataProvider,
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
                                        'attribute' => 'CHUKY',
                                        'value' => function ($model) {
                                            return $model->mANOIDUNG->CHUKY . ' tháng';
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php Pjax::end(); ?>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::a(
                    '<i class="fa fa-angle-double-left"></i> Quay lại',
                    ['update', 'id' => $model->ID_DOTBD], 
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'prevBtn',
                    ]
                )?>
                <?= Html::a(
                    'Tiếp theo <i class="fa fa-angle-double-right"></i>',
                    ['giaoviec', 'id' => $model->ID_DOTBD],
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