<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */

$this->title = $model->MA_NOIDUNG;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Nhóm thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => $model->iDTHIETBI->iDNHOM->TEN_NHOM, 'url' => ['nhomtbi/view', 'id' => $model->iDTHIETBI->ID_NHOM]];
$this->params['breadcrumbs'][] = ['label' => $model->iDTHIETBI->TEN_THIETBI, 'url' => ['thietbi/view', 'id' => $model->ID_THIETBI]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noidungbaotri-view">

    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= (Yii::$app->user->can('edit-noidungbaotri')) ? Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG], ['class' => 'btn btn-primary btn-flat']) : '' ?>
                <?= (Yii::$app->user->can('delete-noidungbaotri')) ? Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG], [
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
                    'ID_THIETBI',
                    'NOIDUNG',
                ],
            ]) ?>
        </div>
    </div>
</div>