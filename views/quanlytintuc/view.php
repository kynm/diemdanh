<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = $model->TITLE;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-view">

    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat']) ?>
            </p>

            <div class="col-lg-12 col-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'TITLE',
                    [
                    	'attribute' => 'CONTENT',
                    	'value' => nl2br($model->CONTENT),
                    	'format' => 'raw',
                    ]
                ],
            ]) ?>
            </div>
        </div>
    </div>
</div>