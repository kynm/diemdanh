<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\Nhomtbi;
use app\models\Noidungbaotrinhomtbi;
/* @var $this yii\web\View */
/* @var $model app\models\Nhomtbi */

?>

    <div class="row">
            <?php Pjax::begin(); ?>
        <?php if(Yii::$app->user->can('create-noidungbaotri')) { ?>
            <div class="col-sm-3 pull-right">
                
                    <?php $addForm =ActiveForm::begin([ 'action' => Url::to(['noidungbaotri/create-for-group']) ]);
                        $noidungAdd = new Noidungbaotrinhomtbi;
                    ?>
                    
                        <div class="col-sm-12">
                            <?= $addForm->field($noidungAdd, 'MA_NOIDUNG')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $addForm->field($noidungAdd, 'ID_NHOM')->dropDownList(
                                ArrayHelper::map(Nhomtbi::find()->all(), 'ID_NHOM', 'TEN_NHOM'),
                                [
                                    'prompt' => 'Chọn nhóm thiết bị',
                                    'options' => [@$_GET['id'] => ['Selected'=>'selected']]
                                ]) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $addForm->field($noidungAdd, 'NOIDUNG')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $addForm->field($noidungAdd, 'CHUKY')->textInput(['maxlength' => true, 'type' => 'number'])->label('Chu kỳ (tháng)') ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $addForm->field($noidungAdd, 'QLTRAM')->dropDownList(
                                [
                                    0 => 'Đội BDUCTT',
                                    1 => 'Quản lý trạm'
                                ],
                                [
                                    'prompt' => 'Chọn bộ phận thực hiện',
                                ])->label('Bộ phận thực hiện') ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $addForm->field($noidungAdd, 'type')->dropDownList(
                                [
                                    0 => 'Đạt / Không đạt',
                                    1 => 'Nhập kết quả'
                                ],
                                [
                                    'prompt' => 'Yêu cầu kết quả công việc',
                                ])->label('Yêu cầu kết quả công việc') ?>
                        </div>
                        <div class="col-sm-12" id="yeucaunhap" hidden>
                            <?= $addForm->field($noidungAdd, 'YEUCAUNHAP')->textArea(['placeholder' => 'Nhập điện áp/số dòng/thời gian xả...v.v...'])->label('Nội dung yêu cầu') ?>
                        </div>
                    
                        <div class="col-md-12">
                            <?= Html::submitButton(
                                '<i class="fa fa-plus"></i> Thêm nội dung', 
                                [
                                    'class'=>'btn btn-primary btn-flat btn-block',
                                    'id' => 'addBtn'
                                ]
                            )?>
                        </div>
                        
                    <?php ActiveForm::end() ?>
                
            </div>
        <?php } ?>
        <div class="<?= (Yii::$app->user->can('create-noidungbaotri')) ? 'col-sm-9' : 'col-sm-12' ?>">
            <div class="table-responsive">
                <?= GridView::widget([
                        'dataProvider' => $contentsProvider,
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            
                            'MA_NOIDUNG',
                            'NOIDUNG',
                            [
                                'attribute' => 'CHUKY',
                                'value' => function ($model) {
                                    return $model->CHUKY . ' tháng';
                                }
                            ],
                            [
                                'attribute' => 'QLTRAM',
                                'value' => function ($model) {
                                    return ($model->QLTRAM) ? 'Quản lý trạm' : 'Đội BDUCTT';
                                }
                            ],
                            [
                                'attribute' => 'YEUCAUNHAP',
                                'value' => function ($model) {
                                    return ($model->YEUCAUNHAP !== "0" ) ? $model->YEUCAUNHAP : "Đạt/Không đạt" ;
                                }
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => (Yii::$app->user->can('edit-loaitb')) ? '{view} {update} {delete}' : '{view}',
                                'buttons'  => [
                                    'view'   => function ($url, $model) {
                                        $url = Url::to(['noidungbaotri/group-view', 'id' => $model->MA_NOIDUNG]);
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => 'view']);
                                    },
                                    'update' => function ($url, $model) {
                                        $url = Url::to(['noidungbaotri/group-update', 'id' => $model->MA_NOIDUNG]);
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => 'update']);
                                    },
                                    'delete' => function ($url, $model) {
                                        $url = Url::to(['noidungbaotri/group-delete', 'id' => $model->MA_NOIDUNG]);
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                            'title'        => 'delete',
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'data-method'  => 'post',
                                        ]);
                                    },
                                ]
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>    
            </div>
        </div>
    </div>
                
<?php
$script = <<< JS
    $( document ).ready(function() {
        typeChange();
        $('#noidungbaotrinhomtbi-type').change(function(){
            typeChange();
        })
    });
    function typeChange(){
        var type = $('#noidungbaotrinhomtbi-type').val();
        if(type == 0){
            $('#yeucaunhap').hide();
        }
        if(type == 1){
            $('#yeucaunhap').show();
        }
    }
JS;
$this->registerJs($script);
?>