<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ketqua */

$this->title = $model->ID_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Ketquas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ketqua-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI], [
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
            'ID_DOTBD',
            'ID_THIETBI',
            'KETQUA',
            'GHICHU',
            'ID_NHANVIEN',
            'ANH1',
            'ANH2',
            'ANH3',
        ],
    ]) ?>

</div>
