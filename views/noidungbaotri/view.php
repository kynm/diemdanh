<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */

$this->title = $model->MA_NOIDUNG;
$this->params['breadcrumbs'][] = ['label' => 'Noidungbaotris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noidungbaotri-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->MA_NOIDUNG], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->MA_NOIDUNG], [
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
            'MA_NOIDUNG',
            'ID_THIETBI',
            'NOIDUNG',
        ],
    ]) ?>

</div>
