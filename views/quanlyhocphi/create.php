<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Tạo mới';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đài viễn thông', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-create">

    <?= $this->render('_form', [
        'model' => $model,
        'dslop' => $dslop,
    ]) ?>

</div>
