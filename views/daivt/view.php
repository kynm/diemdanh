<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $model->ID_DAI;
$this->params['breadcrumbs'][] = ['label' => 'Daivts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID_DAI], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID_DAI], [
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
            'ID_DAI',
            'MA_DAIVT',
            'TEN_DAIVT',
            'DIA_CHI',
            'SO_DT',
            'ID_DONVI',
        ],
    ]) ?>

</div>
