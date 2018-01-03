<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */

$this->title = $model->ID_THIETBI;
$this->params['breadcrumbs'][] = ['label' => 'Thietbis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbi-view">

    

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
            'MA_THIETBI',
            'TEN_THIETBI',
            'iDNHOMTB.TEN_NHOM',
            'HANGSX',
            'THONGSOKT:ntext',
            'PHUKIEN:ntext',
        ],
    ]) ?>

</div>
