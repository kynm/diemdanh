<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Nhanvien */

$this->title = 'Thông tin nhân viên';
$this->params['breadcrumbs'][] = ['label' => 'Nhanviens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-view">

    

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID_NHANVIEN], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID_NHANVIEN], [
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
            'ID_NHANVIEN',
            'MA_NHANVIEN',
            'TEN_NHANVIEN',
            'CHUC_VU',
            'DIEN_THOAI',
            'ID_DONVI',
            'ID_DAI',
            'GHI_CHU',
            'USER_NAME',
        ],
    ]) ?>

</div>
