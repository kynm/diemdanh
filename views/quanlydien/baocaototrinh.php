<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;
use app\models\Donvi;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thống kê sử dụng điện theo trung tâm viễn thông';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['inbaocaototrinhthang'],
            ]); ?>
            <div class="col-md-2 col-xs-2">
                <?= Select2::widget([
                    'name' => 'ID_DONVI',
                    'id' => 'ID_DONVI',
                    'value' => $params['ID_DONVI'] ?? 2,
                    'data' => $dsdonvi,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Chọn đơn vị'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]); ?>
            </div>
            <div class="col-md-2 col-xs-2">
                <?= Select2::widget([
                    'name' => 'NAM',
                    'id' => 'NAM',
                    'value' => $params['NAM'],
                    'data' => $years,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Chọn năm'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]); ?>
            </div>
            <div class="col-md-2 col-xs-2">
                <?= Select2::widget([
                    'name' => 'THANG',
                    'id' => 'THANG',
                    'value' => $params['THANG'],
                    'data' => $months,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Chọn tháng'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]); ?>
            </div>
            <div class="col-md-2 col-xs-2">
                <label>Xuất excel</label>
                <input type="checkbox" name="is_excel" value="1">
            </div>
            <div class="col-md-2 col-xs-2">
                <?= Html::submitButton(
                    '<i class="fa fa-search"></i> Xem báo cáo', 
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'searchBtn',
                        
                    ])
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
