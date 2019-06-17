<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'iDLOAITB.TEN_THIETBI',
        'iDTRAM.TEN_TRAM',
        'SERIAL_MAC',
        'NGAYSX',
        'NGAYSD',
        // 'LANBAODUONGTRUOC',
        // 'LANBAODUONGTIEP',
    ],
]);