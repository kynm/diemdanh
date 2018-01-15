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
            [
                'attribute' => 'ID_DOTBD',
                'value' => $model->iDDOTBD->MA_DOTBD
            ],
            [
                'attribute' => 'ID_THIETBI',
                'value' => $model->iDTHIETBI->iDLOAITB->TEN_THIETBI
            ],
            [
                'attribute' => 'MA_NOIDUNG',
                'value' => $model->mANOIDUNG->NOIDUNG
            ],
            'NOIDUNGMORONG',
            'KETQUA',
            'GHICHU',
            [
                'attribute' => 'ID_NHANVIEN',
                'value' => $model->iDNHANVIEN->TEN_NHANVIEN
            ],
        ],
    ]) ?>

</div>
