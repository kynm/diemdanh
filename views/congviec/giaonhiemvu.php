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
use app\models\Baoduongtong;

$this->title = "Giao nhiệm vụ cho tổ trưởng";
?>

<div class="congviec-phancong">
    <?php 
    $form = ActiveForm::begin(['method' => 'get']); ?>
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
                        'MA_DOTBD',
                        [
                            'attribute' => 'ID_TRAM',
                            'value' => 'tRAMVT.TEN_TRAM'
                        ],
                        [
                            'attribute' => 'ID_NHANVIEN',
                            'value' => 'nHANVIEN.TEN_NHANVIEN'
                        ],
                        [
                            'attribute' => 'ID_BDT',
                            'value' => 'baoduongtong.MA_BDT',
                            'filter'=>ArrayHelper::map(Baoduongtong::find()->where(["TYPE" => 0])->asArray()->all(), 'MA_BDT', 'MA_BDT'),
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
                          // 'data' => ArrayHelper::map(Nhanvien::find()->where(['>', 'ID_NHANVIEN', 0])->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
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
                                'class'=>'btn btn-primary btn-flat'
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

