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
    <p>
        <?= (Yii::$app->user->can('dinhmuc-qldien')) ? Html::a('<i class="fa fa-plus"></i> Tải file mẫu', 'https://drive.google.com/file/d/1MaC85jJHpO7CdnA1rrY7Q9uSIe4x6_UV/view?usp=sharing', ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) : '' ?>
    </p>
<div class="tramvt-update">
    <?= $this->render('_form_import_dinhmuc', [
        'months' => $months,
        'years' => $years,
        'model' => $model,
    ]) ?>
</div>