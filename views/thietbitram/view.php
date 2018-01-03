<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbitram */

$this->title = $model->ID_THIETBI;
$this->params['breadcrumbs'][] = ['label' => 'Thietbitrams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbitram-view">

    

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID_THIETBI], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID_THIETBI], [
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
            'ID_THIETBI',
            'iDLOAITB.TEN_THIETBI',
            'iDTRAM.MA_TRAM',
            'SERIAL_MAC',
            'NGAYSX',
            'NGAYSD',
            'LANBD',
            'LANBAODUONGTRUOC',
            'LANBAODUONGTIEP',
        ],
    ]) ?>

</div>
