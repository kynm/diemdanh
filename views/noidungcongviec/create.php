<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Noidungcongviec */

$this->title = 'Thêm nội dung';
$this->params['breadcrumbs'][] = ['label' => 'Công việc', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noidungcongviec-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
