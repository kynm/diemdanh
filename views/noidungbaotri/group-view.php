<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */

$this->title = $model->MA_NOIDUNG;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noidungbaotri-view">

    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= (Yii::$app->user->can('edit-noidungbaotri')) ? Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['group-update', 'id' => $model->MA_NOIDUNG], ['class' => 'btn btn-primary btn-flat']) : '' ?>
                <?= (Yii::$app->user->can('delete-noidungbaotri')) ? Html::a('<i class="fa fa-trash-o"></i> Xóa', ['group-delete', 'id' => $model->MA_NOIDUNG], [
                    'class' => 'btn btn-danger btn-flat',
                    'data' => [
                        'confirm' => 'Bạn chắc chắn muốn xóa mục này?',
                        'method' => 'post',
                    ],
                ]) : '' ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'MA_NOIDUNG',
                    [ 
                        'attribute' => 'ID_NHOM',
                        'value' => $model->nHOM->TEN_NHOM,
                    ],
                    'NOIDUNG',
                    [ 
                        'attribute' => 'CHUKY',
                        'value' => $model->CHUKY . ' tháng',
                    ],
                    [ 
                        'attribute' => 'QLTRAM',
                        'value' => ($model->QLTRAM == 1) ? 'Quản lý trạm' : 'Đội BDUCTT',
                    ],
                    [ 
                        'attribute' => 'YEUCAUNHAP',
                        'value' => ($model->YEUCAUNHAP == '0') ? 'Đạt/Không đạt' : $model->YEUCAUNHAP,
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>