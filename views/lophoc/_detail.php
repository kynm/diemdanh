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
                    'MA_LOP',
                    [
                        'attribute' => 'TEN_LOP',
                        'value' => function ($model) {
                            return  Html::a($model->TEN_LOP, ['/lophoc/view', 'id' => $model->ID_LOP], ['title' => $model->TEN_LOP, 'data-pjax' => 0]);
                        },
                        'format' => 'raw',
                    ],
                    // 'DIA_CHI',
                    // 'SO_DT',
                    [
                        'attribute' => 'SOHOCSINH',
                        'value' => function ($model) {
                            return  '<span style="font-size: 20px; color: red">' . $model->getDshocsinh()->count() . '</span>';
                        },
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>
    </div>