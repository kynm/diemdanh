<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */

$this->title = $model->activity_type;
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->activity_type], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->activity_type], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Bạn chắc chắn muốn xóa mục này?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'activity_type',
            'activity_name',
            'class',
        ],
    ]) ?>

</div>
