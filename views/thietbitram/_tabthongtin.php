<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'iDLOAITB.TEN_THIETBI',
        'iDTRAM.MA_TRAM',
        'SERIAL_MAC',
        'NGAYSX',
        'NGAYSD',
        'LANBD',
        'LANBAODUONGTRUOC',
        'LANBAODUONGTIEP',
    ],
]);