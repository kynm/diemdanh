<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Baoduongtong;
use yii\helpers\ArrayHelper;
?>
<div class="table-responsive">
<?php
Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $planProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'MA_DOTBD',
            [
                'attribute' => 'ID_TRAM',
                'value' => 'tRAMVT.TEN_TRAM'
            ],
            [
                'attribute' => 'NGAY_DUKIEN',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'NGAY_KT_DUKIEN',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'ID_NHANVIEN',
                'value' => 'nHANVIEN.TEN_NHANVIEN'
            ],
            [
                'attribute' => 'ID_BDT',
                'value' => 'baoduongtong.MA_BDT',
                'filter'=>ArrayHelper::map(Baoduongtong::find()->asArray()->all(), 'MA_BDT', 'MA_BDT'),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->can('edit-dbd') ? '{view} {update} {delete}' : '{view}',
            ],
        ],
    ]);
Pjax::end();
?>
</div>