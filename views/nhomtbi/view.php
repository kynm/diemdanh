<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Nhomtbi */

$this->title = $model->ID_NHOM;
$this->params['breadcrumbs'][] = ['label' => 'Nhomtbis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhomtbi-view">

    

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID_NHOM], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID_NHOM], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID_NHOM',
            'MA_NHOM',
            'TEN_NHOM',
        ],
    ]) ?>

</div>
