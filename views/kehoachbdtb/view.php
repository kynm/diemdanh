<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Kehoachbdtb */

$this->title = $model->ID_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Kehoachbdtbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kehoachbdtb-view">

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
            'MA_NOIDUNG',
            'ID_NHANVIEN',
        ],
    ]) ?>

</div>
