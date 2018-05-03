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

    <div class="box box-primary">
        <div class="box-body">
            <?php 
                if (Yii::$app->user->can('edit-nhanvien')) { ?>
                <p>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID_NHANVIEN], ['class' => 'btn btn-primary btn-flat']) ?>
                <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID_NHANVIEN], [
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
                    'ID_NHANVIEN',
                    'MA_NHANVIEN',
                    'TEN_NHANVIEN',
                    [ 
                        'attribute' => 'CHUC_VU',
                        'value' => $model->chucvu->ten_chucvu
                    ],
                    'DIEN_THOAI',
                    [ 
                        'attribute' => 'ID_DONVI',
                        'value' => $model->iDDONVI->TEN_DONVI
                    ],
                    [ 
                        'attribute' => 'ID_DAI',
                        'value' => @$model->iDDAI->TEN_DAIVT
                    ],
                    'GHI_CHU',
                    'USER_NAME',
                ],
            ]) ?>
        </div>
    </div>
</div>