<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $model->MA_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đài viễn thông', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <p>
        <?php if (Yii::$app->user->can('quanlyhocsinh')):?>
            <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID_LOP], ['class' => 'btn btn-primary btn-flat']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('diemdanhlophoc')):?>
            <?= Html::a('<i class="fa fa-pencil-square-o"></i> Quản lý điểm danh', ['lophoc/quanlydiemdanh', 'id' => $model->ID_LOP], ['class' => 'btn btn-primary btn-flat']) ?>
        <?php endif; ?>
        <?= Html::a('<i class="fa fa-pencil-square-o"></i> Quản lý học sinh', ['quanlyhocsinh', 'id' => $model->ID_LOP], ['class' => 'btn btn-primary btn-flat']) ?>
        <?php if (Yii::$app->user->can('quanlyhocsinh') && !$model->getDshocsinh()->count()): ?>
            <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID_LOP], [
                'class' => 'btn btn-danger btn-flat',
                'data' => [
                    'confirm' => 'Bạn chắc chắn muốn xóa mục này?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>
    <?= $this->render('_detail', [
        'model' => $model,
    ]) ?>
</div>
