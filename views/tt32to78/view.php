<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = $model->TEN_KH;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['hoadondientumoi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị chủ quản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-view">

    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?php if(!Yii::$app->user->can('quanly-dulieu')): ?>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Tiếp xúc khách hàng', ['tiepxuckhachhang', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
                <?php endif; ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'LOAIHETHONG',
                    'TEN_KH',
                    'MST',
                    'DIACHI',
                    'TEN_KETOAN',
                    [
                        'attribute' => 'LIENHE',
                        'value' => Html::a($model->LIENHE,"tel:".$model->LIENHE),
                        'format' => 'raw',
                    ],
                    'EMAIL',
                    'ghichu',
                    'TRANGTHAINANGCAP',
                    'TEN_NV_KD',
                    [
                        'attribute' => 'link',
                        'value' => Html::a($model->link, $model->link, ['target' => '_blank']),
                        'format' => 'raw',
                    ],
                    'taikhoan',
                    'matkhau',
                    'view',
                    'ghichu',
                ],
            ]) ?>
        </div>
    </div>
        <?= $this->render('_lichsu_tiepxuc', [
        'lichsutiepxuc' => $model->lichsutiepxuc,
    ]) ?>
</div>
