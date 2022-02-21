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
    <?php if (in_array($model->status, [0,2])): ?>
        <div class="xuly-baohong">
        <?= $this->render('_form_xl_baohong', [
            'model' => $model,
        ]) ?>
    <?php endif; ?>
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
                        'attribute' => 'nhanvien_id',
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
                    'ngay_bh',
                    'ngay_xl',
                    'noidung',
                    'ghichu',
                    [
                        'attribute' => 'nguyennhan_id',
                        'value' => $model->nguyennhan ? $model->nguyennhan->nguyennhan : '',
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
</div>
