<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Daivt;
use app\models\Nhanvien;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
$this->title = 'Import công ty';
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
    <p>
        <?= (Yii::$app->user->can('Administrator')) ? Html::a('<i class="fa fa-plus"></i> Tải file mẫu', 'https://docs.google.com/spreadsheets/d/1eVPez4436ySG7v6pnqyalNnlsN9zoDzb4lDt3XsBQRg/edit?usp=sharing', ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) : '' ?>
    </p>
<div class="tramvt-update">
    <?= $this->render('_form_import', [
        'dsDichvu' => $dsDichvu,
        'model' => $model,
    ]) ?>
</div>