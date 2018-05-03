<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Donvi;
use app\models\Tramvt;
use app\models\Thietbitram;
use app\models\Noidungcongviec;
use app\models\Nhanvien;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Điều chuyển thiết bị';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dieuchuyenthietbi-index">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            
            <?php Pjax::begin(); ?>
            
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <strong>Thiết bị chọn điều chuyển</strong>
                    </div>
                    <div class="box-body">
                          
                        <?= GridView::widget([
                            'dataProvider' => $unselectedProvider,
                            // 'showHeader' => true,
                            'layout' => "{items}{pager}",
                            'emptyText' => false,
                            'columns' => [
                                ['class' => 'yii\grid\CheckboxColumn',
                                    // 'name' => 'AddSelection'
                                ],
                                [
                                    'attribute' => 'ID_THIETBI',
                                    'value' => 'iDTHIETBI.iDLOAITB.TEN_THIETBI',
                                ],
                            ],
                        ]) ?>
                        
                    </div>
                </div>
            </div>
            <div class="form-group col-md-3">
                    
                    
                    <?= Select2::widget([
                        'name' => 'idtramdich',
                        'id' => 'idtramdich',
                        // 'value' => '',
                        'data' => ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'MA_TRAM'),
                        'options' => [
                            'placeholder' => 'Chọn trạm đích ...', 
                            ]
                    ]); ?>
                    <?= Html::textarea(
                        'lydodieuchuyen',
                        '', 
                        [
                            'placeholder' => 'Lý do điều chuyển',
                            'style' => ['margin-top' => '15px', 'margin-bottom' => '15px'],
                            'class' => 'form-control',
                            'id' => 'lydodieuchuyen',
                        ]);
                    ?>
                    <?= DatePicker::widget([
                        'name' => 'ngaychuyen',
                        'id' => 'ngaychuyen',
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Ngày chuyển ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                        ],
                    ]); ?>
                    <?= Html::button(
                        'Thêm <i class="fa fa-angle-double-right"></i>', 
                        [
                            'class'=>'btn btn-primary btn-flat btn-block',
                            'id' => 'addBtn',
                            'style' => ['margin-top' => '15px'],
                            'onclick' => '
                                var keys = $("#w1").yiiGridView("getSelectedRows");
                                $.pjax.reload({ 
                                    container: "#p0",
                                    type: "POST",
                                    url: " '. Url::to(['tramvt/dieuchuyen', 'id' => $_GET['id'] ]) .'", 
                                    data: {
                                        addkeylist: keys,
                                        idtramdich : $("#idtramdich").val(),
                                        lydodieuchuyen : $("#lydodieuchuyen").val(),
                                        ngaychuyen : $("#ngaychuyen").val(),
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
                                    type: "POST",
                                    url: "'. Url::to(['tramvt/dieuchuyen', 'id' => $_GET['id'] ]) .'", 
                                    data: {
                                        rmvkeylist: keys
                                    }
                                }); 
                            '
                        ]
                    )?>               
            </div>
            <div class="col-md-5">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <strong>Danh sách điều chuyển</strong>
                    </div>
                    <div class="box-body">
                        <div id="dsnoidung"></div>
                         
                        <?= GridView::widget([
                            'dataProvider' => $selectedProvider,
                            // 'showHeader' => false,
                            'layout' => "{items}\n{pager}",
                            'emptyText' => false,
                            'columns' => [
                                ['class' => 'yii\grid\CheckboxColumn',
                                    // 'name' => 'RmvSelection'
                                ],
                                [
                                    'attribute' => 'ID_THIETBI',
                                    'value' => 'iDTHIETBI.iDLOAITB.TEN_THIETBI',
                                ],
                                [
                                    'attribute' => 'ID_TRAM_DICH',
                                    'value' => 'iDTRAMDICH.MA_TRAM',
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
                    '<i class="fa fa-check"></i> Hoàn tất',
                    ['tramvt/hoantatdieuchuyen', 'id' => $_GET['id']],
                    [
                        'class'=>'btn btn-primary btn-flat'
                    ]
                )?> 
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>