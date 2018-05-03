<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $model->MA_DAIVT;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đài viễn thông', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID_DAI], ['class' => 'btn btn-primary btn-flat']) ?>
                <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID_DAI], [
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
                    // 'ID_DAI',
                    'MA_DAIVT',
                    'TEN_DAIVT',
                    'DIA_CHI',
                    'SO_DT',
                    [
                        'attribute' => 'ID_DONVI',
                        'value' => $model->iDDONVI->TEN_DONVI,
                    ]
                ],
            ]) ?>
        </div>
    </div>
</div>
