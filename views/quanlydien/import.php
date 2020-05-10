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
$this->title = 'Đẩy dữ liệu điện';
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="tramvt-update">
    <?= $this->render('_form_import', [
        'months' => $months,
        'years' => $years,
        'model' => $model,
    ]) ?>
</div>