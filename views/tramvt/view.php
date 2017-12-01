<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */

$this->title = $model->ID_TRAM;
$this->params['breadcrumbs'][] = ['label' => 'Tramvts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramvt-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID_TRAM], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID_TRAM], [
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
            'ID_TRAM',
            'MA_TRAM',
            'DIADIEM',
            'iDDAIVT.TEN_DAIVT',
            'iDNHANVIEN.TEN_NHANVIEN',
        ],
    ]) ?>

</div>
