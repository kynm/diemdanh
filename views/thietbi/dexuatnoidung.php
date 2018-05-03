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
use app\models\Dexuatnoidung;
use app\models\Chukybaoduong;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */

$this->title = $model->TEN_THIETBI .': Đề xuất nội dung';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => $model->iDNHOMTB->TEN_NHOM, 'url' => ['nhomtbi/view', 'id' => $model->ID_NHOMTB]];
$this->params['breadcrumbs'][] = ['label' => $model->TEN_THIETBI, 'url' => ['view', 'id' => $model->ID_THIETBI]];
$this->params['breadcrumbs'][] = 'Đề xuất nội dung';
?>
<div class="thietbi-view">
    <div class="box box-primary">
        <?php $addForm =ActiveForm::begin();
            $noidungAdd = new Dexuatnoidung;
        ?>
        <div class="box-body">
            <div class="col-sm-4">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <div class="col-sm-12">
                    <?php Pjax::begin(); ?> 
                    <div class="table-responsive">
                        <?= GridView::widget([
                            
                            'dataProvider' => $noidungProvider,
                            // 'filterModel' => $noidungSearchModel,
                            'columns' => [
                                ['class' => 'yii\grid\CheckboxColumn',
                                    'name' => 'AddSelection'
                                ],
                                'NOIDUNG',
                                // [
                                //     'attribute' => 'MA_NOIDUNG',
                                //     'value' => 'mANOIDUNG.NOIDUNG'
                                // ],
                            ],
                        ]); ?>
                    </div>   
                    <?php Pjax::end(); ?>
                </div>
            </div>

            <div class="col-sm-2">                    
                
                <?= $addForm->field($noidungAdd, 'CHUKYBAODUONG')->dropDownList(ArrayHelper::map(Chukybaoduong::find()->all(), 'id', 'alias'), [
                        'prompt' => 'Chọn chu kỳ',
                        'onchange' => '$.pjax.reload({
                            container: "#p1", 
                            url: " '.Url::to(['thietbi/dexuatnoidung']) .'", 
                            data: {
                                id: '.$model->ID_THIETBI.',
                                chuky: $(this).val(),
                            }
                        });'
                    ])  ?>
                

                <div class="text-center">
                    <?= Html::button(
                        'Thêm <i class="fa fa-angle-double-right"></i>', 
                        [
                            'class'=>'btn btn-primary btn-flat btn-block',
                            'id' => 'addBtn',
                            'onclick' => '
                                var keys = $("#w1").yiiGridView("getSelectedRows");
                                $.pjax.reload({ 
                                    container: "#p1",
                                    type: "POST", 
                                    url: " '.Url::to(['thietbi/dexuatnoidung', 'id' => $model->ID_THIETBI ]) .' ", 
                                    data: {
                                        addkeylist: keys,
                                        chuky: $("#dexuatnoidung-chukybaoduong").val(),
                                        id: '.$model->ID_THIETBI.',
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
                                    container: "#p1",
                                    type: "POST", 
                                    url: " '.Url::to(['thietbi/dexuatnoidung', 'id' => $model->ID_THIETBI ]) .' ", 
                                    data: {
                                        rmvkeylist: keys,
                                        id: '.$model->ID_THIETBI.',
                                    }
                                }); 
                            '
                        ]
                    )?>
                </div>  
            </div>

            <div class="col-sm-6">
                <div class="col-sm-12">
                    <?php Pjax::begin(); ?>  
                    <div class="table-responsive">  
                        <?= GridView::widget([
                            
                            'dataProvider' => $khuyennghiProvider,
                            // 'filterModel' => $khuyennghiSearchModel,
                            'columns' => [
                                ['class' => 'yii\grid\CheckboxColumn',
                                    'name' => 'RemoveSelection'
                                ],
                                [
                                    'attribute' => 'CHUKYBAODUONG',
                                    'value' => 'cHUKYBAODUONG.alias'
                                ],
                                'LANBD',
                                [
                                    'attribute' => 'MA_NOIDUNG',
                                    'value' => 'mANOIDUNG.NOIDUNG'
                                ],
                            ],
                        ]); ?>
                        </div>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        <?php ActiveForm::end() ?>
        </div>
    </div>    
</div>