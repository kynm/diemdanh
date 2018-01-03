<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'Thêm đơn vị mới';
$this->params['breadcrumbs'][] = ['label' => 'Donvis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
