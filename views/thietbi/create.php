<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */

$this->title = 'Thêm loại thiết bị mới';
$this->params['breadcrumbs'][] = ['label' => 'Thietbis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbi-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
