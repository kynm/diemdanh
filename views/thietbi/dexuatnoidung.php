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
use app\models\Chukybaoduong;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */

$this->title = $thietbi->TEN_THIETBI .': Đề xuất nội dung';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => $thietbi->iDNHOM->TEN_NHOM, 'url' => ['nhomtbi/view', 'id' => $thietbi->ID_NHOM]];
$this->params['breadcrumbs'][] = ['label' => $thietbi->TEN_THIETBI, 'url' => ['view', 'id' => $thietbi->ID_THIETBI]];
$this->params['breadcrumbs'][] = 'Đề xuất nội dung';
?>
<div class="thietbi-view">
    <div class="box box-primary">
        <?php $addForm = ActiveForm::begin(); ?>
        <?php Pjax::begin(); ?> 
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <div class="box-body">
            <div class="col-sm-5">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <strong>Nội dung của nhóm</strong>
                    </div>
                    <div class="box-body">
                        
                        <div class="table-responsive">
                            <?= GridView::widget([
                                
                                'dataProvider' => $unselectedProvider,
                                // 'filterModel' => $noidungSearchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\CheckboxColumn',
                                        'name' => 'AddSelection'
                                    ],
                                    'NOIDUNG',
                                    [
                                        'attribute' => 'CHUKY',
                                        'value' => function($model) {
                                            return $model->CHUKY . ' tháng';
                                        }
                                    ],
                                ],
                            ]); ?>
                        </div>   
                        
                    </div>
                </div>
            </div>

            <div class="col-sm-2">                    
                
                <div class="text-center">
                    <?= Html::button(
                        'Thêm <i class="fa fa-angle-double-right"></i>', 
                        [
                            'class'=>'btn btn-primary btn-flat btn-block',
                            'id' => 'addBtn',
                            'onclick' => '
                                var keys = $("#w1").yiiGridView("getSelectedRows");
                                $.pjax.reload({ 
                                    container: "#p0",
                                    type: "POST", 
                                    url: " '.Url::to(['thietbi/dexuatnoidung', 'id' => $thietbi->ID_THIETBI ]) .' ", 
                                    data: {
                                        addkeylist: keys,
                                        id: '.$thietbi->ID_THIETBI.',
                                    }
                                }); 
                            '
                        ]
                    )?>
                </div>

                <div class="text-center" style="margin-top: 20px">
                    <?= Html::button(
                        '<i class="fa fa-angle-double-left"></i> Xóa', 
                        [
                            'class'=>'btn btn-danger btn-flat btn-block',
                            'id' => 'removeBtn',
                            
                            'onclick' => '
                                var keys = $("#w2").yiiGridView("getSelectedRows");

                                $.pjax.reload({ 
                                    container: "#p0",
                                    type: "POST", 
                                    url: " '.Url::to(['thietbi/dexuatnoidung', 'id' => $thietbi->ID_THIETBI ]) .' ", 
                                    data: {
                                        rmvkeylist: keys,
                                        id: '.$thietbi->ID_THIETBI.',
                                    }
                                }); 
                            '
                        ]
                    )?>
                </div>  
            </div>

            <div class="col-sm-5">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <strong>Nội dung thiết bị</strong>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">  
                            <?= GridView::widget([
                                
                                'dataProvider' => $selectedDataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\CheckboxColumn',
                                        'name' => 'RemoveSelection'
                                    ],
                                    'NOIDUNG',
                                    [
                                        'attribute' => 'CHUKY',
                                        'value' => function($model) {
                                            return $model->CHUKY . ' tháng';
                                        }
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php Pjax::end(); ?>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::a(
                    '<i class="fa fa-check"></i> Hoàn thành', 
                    ['view', 'id' => $thietbi->ID_THIETBI],
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'finish',
                    ]
                )?> 
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>    
</div>