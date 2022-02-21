<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Báo hỏng';
$this->params['breadcrumbs'][] = ['label' => 'Báo hỏng', 'url' => ['baohong/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <div class="box box-primary">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'donvi_id',
                        'value' => $model->iDDONVI->TEN_DONVI,
                    ],
                    [
                        'attribute' => 'user_id',
                        'value' => $model->nHANVIEN->TEN_NHANVIEN,
                    ],
                    [
                        'attribute' => 'nhanvien_xl_id',
                        'value' => $model->nHANVIENXULY->TEN_NHANVIEN,
                    ],
                    [
                        'attribute' => 'status',
                        'value' => Html::button(statusbaohong()[$model->status], ['class' => 'btn btn-primary']),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'dichvu_id',
                        'value' => $model->dichvu->ten_dv,
                    ],
                    'ten_kh',
                    'diachi',
                    'so_dt',
                    'noidung',
                ],
            ]) ?>
            <?php if (Yii::$app->user->can('dmdv-xlbaohong')): ?>
                <?=  Html::a('Xử lý báo hỏng', ['xulybaohong', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
