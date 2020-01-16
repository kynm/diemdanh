<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kop\y2sp\ScrollPager;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Nhanvien;

$this->title = "Giao công việc trong đợt bảo dưỡng";
?>

<div class="congviec-phancong">
    <?php 
    $form = ActiveForm::begin(['method' => 'post']); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-md-9">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'responsiveWrap' => false,
                    'floatHeader'=>true,
                    // 'floatHeaderOptions'=>['scrollingTop'=>'50'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'name' => 'AddSelection'
                        ],
                        [
                            'attribute' => 'ID_THIETBI',
                            'value' => 'tHIETBI.iDLOAITB.TEN_THIETBI'
                        ],
                        [
                            'attribute' => 'ID_DOTBD',
                            'value' => 'dOTBD.MA_DOTBD'
                        ],
                        [
                            'attribute' => 'MA_NOIDUNG',
                            'value' => 'mANOIDUNG.NOIDUNG'
                        ],
                        [
                            'attribute' => 'ID_NHANVIEN',
                            'value' => 'nHANVIEN.TEN_NHANVIEN'
                        ],
                    ],
                  ]); ?>
            </div>
            <div class="col-md-3">
                <div class="panel panel-primary affix">
                  <div class="panel-body">
                    <div class="col-sm-12">
                        <?= Select2::widget([
                            'name' => 'ID_NHANVIEN',
                            'data' => ArrayHelper::map($listNhanvien, 'ID_NHANVIEN', 'TEN_NHANVIEN'),
                            'theme' => Select2::THEME_BOOTSTRAP,
                            'pluginOptions' => [
                                'placeholder' => 'Chọn nhân viên thực hiện',
                                'allowClear' => true
                            ],
                            ]);
                        ?>
                    </div>
                      
                    <div class="col-sm-12" style="margin-top: 15px">
                      <?= Html::submitButton(
                          '<i class="glyphicon glyphicon-link"></i> Giao việc', 
                          [
                              'class'=>'btn btn-primary btn-flat',
                          ]); 
                      ?>
                    </div>
                  </div>
                </div>
            </div>
        </div>
                    
    </div>
    <?php ActiveForm::end();  ?>
</div>

