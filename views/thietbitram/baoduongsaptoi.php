<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Thiết bị sắp bảo dưỡng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbitram-baoduongsaptoi">
    <div class="box box-primary">
        <div class="box-body">
            
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'ID_LOAITB',
                            'value' => 'iDLOAITB.TEN_THIETBI'
                        ],
                        [
                            'attribute' => 'ID_TRAM',
                            'value' => 'iDTRAM.TEN_TRAM'
                        ],
                        'LANBAODUONGTRUOC',
                        'LANBAODUONGTIEP',

                        // [
                        //     'class' => 'yii\grid\ActionColumn',
                        //     'template' => (Yii::$app->user->can('edit-tbitram')) ? '{view} {update} {delete}' : '{view}'
                        // ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
