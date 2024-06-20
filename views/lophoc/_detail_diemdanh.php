<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
?>
<div class="box box-primary">
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'ID_LOP',
                'TIEUDE',
                [
                    'attribute' => 'LOP',
                    'value' => function ($model) {
                        return  Html::a($model->lop->TEN_LOP, ['/lophoc/view', 'id' => $model->lop->ID_LOP], ['title' => $model->lop->TEN_LOP, 'data-pjax' => 0]);
                    },
                    'format' => 'raw',
                ],
                'NGAY_DIEMDANH',
            ],
        ]) ?>
    </div>
</div>