<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungcongviec */

$this->title = $model->ID_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Noidungcongviecs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noidungcongviec-view">
    <div class="box box-primary">
        <div class="box-body">
        <p>
            <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG, 'ID_NHANVIEN' => $model->ID_NHANVIEN], ['class' => 'btn btn-primary btn-flat']) ?>
            <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG, 'ID_NHANVIEN' => $model->ID_NHANVIEN], [
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
                'ID_DOTBD',
                'ID_THIETBI',
                'MA_NOIDUNG',
                'GHICHU:ntext',
                'TRANGTHAI',
                'ID_NHANVIEN',
                'KETQUA',
            ],
        ]) ?>
        </div>
    </div>
</div>