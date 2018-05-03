<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = $model->MA_DONVI;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị chủ quản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-view">

    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID_DONVI], ['class' => 'btn btn-primary btn-flat']) ?>
                <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID_DONVI], [
                    'class' => 'btn btn-danger btn-flat',
                    'data' => [
                        'confirm' => 'Bạn chắc chắn muốn xóa mục này?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // 'ID_DONVI',
                    'MA_DONVI',
                    'TEN_DONVI',
                    'DIA_CHI',
                    'SO_DT',
                    [
                        'attribute' => 'CAP_TREN',
                        'value' => $model->cAPTREN->TEN_DONVI,
                    ]
                ],
            ]) ?>
        </div>
    </div>
</div>
