<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Baoduongtong;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */

$this->title = 'Đăng ký bảo dưỡng';
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="dotbaoduong-create">
        <?php $form = ActiveForm::begin(['method' => 'post']); ?>
        <div class="box box-primary">
            <div class="box-header">
                Đăng ký bảo dưỡng
            </div>
            <div class="box-body">
                <div class="col col-md-4">
                    <?= Select2::widget([
                        'name' => 'ID_BDT',
                        'data' => ArrayHelper::map($list_baoduongtong, 'ID_BDT', 'MO_TA'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn đợt bảo dưỡng tổng',
                            'allowClear' => true
                        ],
                        ]);
                    ?>
                </div>
                <div class="col col-md-4">
                    <?= Select2::widget([
                        'name' => 'ID_NHANVIEN',
                        'data' => ArrayHelper::map($list_nhanvien, 'ID_NHANVIEN', 'TEN_NHANVIEN'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'placeholder' => 'Chọn nhân viên thực hiện',
                            'allowClear' => true
                        ],
                        ]);
                    ?>
                </div>
                <div class="col col-md-4">
                    <?= DatePicker::widget([
                            'name' => 'check_issue_date', 
                            // 'value' => date('d-M-Y', strtotime('+2 days')),
                            'options' => ['placeholder' => 'Chọn tháng dự kiến bảo dưỡng'],
                            'pluginOptions' => [
                                'startView'=>'year',
                                'minViewMode'=>'months',
                                'format' => 'mm-yyyy',
                                'todayHighlight' => true
                            ]
                        ]);
                    ?>
                </div>
                <div class="col-md-12">
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'responsiveWrap' => false,
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'name' => 'AddSelection'
                            ],
                            'TEN_TRAM',
                            'DIADIEM'
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
            <div class="box-footer with-border">
                <?= Html::submitButton(
                    '<i class="glyphicon glyphicon-check"></i> Đăng ký', 
                    [
                        'class'=>'btn btn-primary btn-flat',
                    ]); 
                ?>
            </div>
        </div>
        <?php ActiveForm::end();  ?>
</div>
