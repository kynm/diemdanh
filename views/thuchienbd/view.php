<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Thuchienbd */

$this->title = $model->ID_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Thuchienbds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thuchienbd-view">

    

    <p>
        <?= Html::a('Update', ['update', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG], [
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
            'ID_DOTBD',
            'ID_THIETBI',
            'MA_NOIDUNG',
            'NOIDUNGMORONG',
            'KETQUA',
            'GHICHU',
            'ID_NHANVIEN',
        ],
    ]) ?>

</div>
