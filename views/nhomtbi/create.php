<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Nhomtbi */

$this->title = 'Thêm nhóm thiết bị mới';
$this->params['breadcrumbs'][] = ['label' => 'Nhomtbis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhomtbi-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
