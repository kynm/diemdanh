<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */

$this->title = 'Thêm đợt bảo dưỡng';
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dotbaoduong-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
