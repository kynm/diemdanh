<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Dotbaoduong;
use app\models\Noidungbaotri;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Thietbi;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */

$this->title = $model->TEN_THIETBI;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => $model->iDNHOMTB->TEN_NHOM, 'url' => ['nhomtbi/view', 'id' => $model->ID_NHOMTB]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbi-view">
    <div class="row">
        <?php if(Yii::$app->user->can('create-noidungbaotri')) { ?>
            <div class="col-sm-3 pull-right">
                <div class="box box-primary">
                    <?php $addForm =ActiveForm::begin([ 'action' => Url::to(['noidungbaotri/create']) ]);
                        $noidungAdd = new Noidungbaotri;
                    ?>
                    <div class="box-body">
                        <div class="col-sm-12">
                            <?= $addForm->field($noidungAdd, 'MA_NOIDUNG')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $addForm->field($noidungAdd, 'ID_THIETBI')->dropDownList(
                                ArrayHelper::map(Thietbi::find()->all(), 'ID_THIETBI', 'TEN_THIETBI'),
                                [
                                    'prompt' => 'Chọn nhóm thiết bị',
                                    'options' => [@$_GET['id'] => ['Selected'=>'selected']]
                                ]) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $addForm->field($noidungAdd, 'NOIDUNG')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-md-12">
                            <?= Html::submitButton(
                                '<i class="fa fa-plus"></i> Thêm nội dung', 
                                [
                                    'class'=>'btn btn-primary btn-flat btn-block',
                                    'id' => 'addBtn'
                                ]
                            )?>
                        </div>
                        <div class="col-md-12" style="margin-top: 15px">
                            <?= Html::a(
                                '<i class="fa fa-lightbulb-o"></i> Đề xuất chu kỳ/nội dung', 
                                ['thietbi/dexuatnoidung', 'id' => $model->ID_THIETBI], 
                                [
                                    'class'=>'btn btn-warning btn-flat btn-block',
                                    'id' => 'addBtn'
                                ]
                            )?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        <?php } ?>

        <div class="<?= (Yii::$app->user->can('create-noidungbaotri')) ? 'col-sm-9' : 'col-sm-12' ?>">
            <div class="box box-primary">
                <div class="box-body">
                    <p class="form-inline">
                        <div class="form-group col-md-3">
                            <label>Mã thiết bị</label>
                            <input type="text" class="form-control" disabled="true" value="<?= $model->MA_THIETBI ; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tên thiết bị</label>
                            <input type="text" class="form-control" disabled="true" value="<?= $model->TEN_THIETBI ; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Nhóm thiết bị</label>
                            <input type="text" class="form-control" disabled="true" value="<?= $model->iDNHOMTB->TEN_NHOM ; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Hãng sản xuất</label>
                            <input type="text" class="form-control" disabled="true" value="<?= $model->HANGSX ; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Thông số kỹ thuật</label>
                            <textarea class="form-control" disabled="true" rows="4"><?= $model->THONGSOKT ; ?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phụ kiện</label>
                            <textarea class="form-control" disabled="true" rows="4"><?= $model->PHUKIEN ; ?></textarea>
                        </div>
                    </p>

                    <?php Pjax::begin(); ?>  
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "{items}{pager}",
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'MA_NOIDUNG',
                                ['attribute' => 'ID_THIETBI', 'value' => 'iDTHIETBI.TEN_THIETBI'],
                                'NOIDUNG',

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => (Yii::$app->user->can('edit-noidungbaotri')) ? '{view} {update} {delete}' : '{view}',
                                    
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'view') {
                                            $url = Url::to(['noidungbaotri/view', 'id' => $key ]);
                                            return $url;
                                        }
                                        if ($action === 'update') {
                                            $url = Url::to(['noidungbaotri/update', 'id' => $key ]);
                                            return $url;
                                        }
                                        if ($action === 'delete') {
                                            $url = Url::to(['noidungbaotri/delete', 'id' => $key ]);
                                            return $url;
                                        }
                                    }
                                ],
                            ],
                        ]); ?>
                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>