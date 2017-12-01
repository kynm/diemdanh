<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nhanvien */

$this->title = 'Thay đổi thông tin nhân viên';
$this->params['breadcrumbs'][] = ['label' => 'Nhanviens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_NHANVIEN, 'url' => ['view', 'id' => $model->ID_NHANVIEN]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nhanvien-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
