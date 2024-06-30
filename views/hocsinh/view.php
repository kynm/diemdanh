<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\hocsinh */

$this->title = 'Thông tin';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Nhân viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hocsinh-view">

    <div class="box box-primary">
        <div class="box-body">
            <?php 
                if (Yii::$app->user->can('edit-hocsinh')) { ?>
                <p>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat']) ?>
<!--                 <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID], [
                    'class' => 'btn btn-danger btn-flat',
                    'data' => [
                        'confirm' => Yii::t('app', 'Bạn chắc chắn muốn xóa mục này?'),
                        'method' => 'post',
                    ],
                ]) ?> -->
                </p>
            <?php } ?>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'ID',
                    'HO_TEN',
                    'NGAY_SINH',
                    'ID_LOP',
                    [ 
                        'attribute' => 'ID_LOP',
                        'value' => $model->lop->TEN_LOP
                    ],
                    'DIA_CHI',
                    'NGAY_BD',
                    'NGAY_KT',
                ],
            ]) ?>
        </div>
    </div>
</div>