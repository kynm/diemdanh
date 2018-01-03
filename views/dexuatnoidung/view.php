<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Dexuatnoidung */

$this->title = $model->ID_LOAITB;
$this->params['breadcrumbs'][] = ['label' => 'Dexuatnoidungs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dexuatnoidung-view">

    <p>
        <?= Html::a('Update', ['update', 'ID_LOAITB' => $model->ID_LOAITB, 'LAN_BD' => $model->LAN_BD, 'MA_NOIDUNG' => $model->MA_NOIDUNG], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID_LOAITB' => $model->ID_LOAITB, 'LAN_BD' => $model->LAN_BD, 'MA_NOIDUNG' => $model->MA_NOIDUNG], [
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
            'ID_LOAITB',
            'LAN_BD',
            'CHUKYBAODUONG',
            'MA_NOIDUNG',
        ],
    ]) ?>

</div>
