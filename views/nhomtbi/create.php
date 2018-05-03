<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Nhomtbi */

$this->title = 'Thêm nhóm thiết bị';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Nhóm thiết bị', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhomtbi-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
