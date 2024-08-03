<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

$this->title = $model->HO_TEN;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hocsinh-view">
</div>
<div class="row">
    <div class="col-md-3">
        <?= $this->render('_detail', ['model' => $model,]) ?>
    </div>
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?= $this->render('/partial/_header_hocsinh', ['model' => $model,]) ?>
            </ul>
            <div class="tab-content">
                <?= $this->render('_form', [
                    'model' => $model,
                    'dslop' =>$dslop,
                ]) ?>
            </div>
        </div>
    </div>
</div>