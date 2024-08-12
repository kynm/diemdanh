<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Nhanvien */

$this->title = 'Thông tin';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Nhân viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-view">
    <?= $this->render('/partial/_header_hocphithutruoc', []) ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php 
                if (Yii::$app->user->can('quanlyhocphi') && $model->STATUS == 1) { ?>
                <p>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat']) ?>
                <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID], [
                    'class' => 'btn btn-danger btn-flat',
                    'data' => [
                        'confirm' => Yii::t('app', 'Bạn chắc chắn muốn xóa mục này?'),
                        'method' => 'post',
                    ],
                ]) ?>
                </p>
            <?php } ?>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'ID_HOCSINH',
                        'value' => $model->hocsinh ? $model->hocsinh->HO_TEN : 'Không tìm thấy học sinh',
                    ],
                    'SOTIEN',
                    'SO_BH',
                    'NGAY_BD',
                    'NGAY_KT',
                    [
                        'attribute' => 'GHICHU',
                        'value' => $model->GHICHU,
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>