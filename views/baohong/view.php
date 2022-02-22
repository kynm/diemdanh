<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Báo hỏng';
$this->params['breadcrumbs'][] = ['label' => 'Báo hỏng', 'url' => ['baohong/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <div class="box box-primary">
        <div class="box-body">
            <?= $this->render('_detail', [
                'model' => $model,
            ]) ?>
            <div class="box-footer">
            <?php if (Yii::$app->user->can('dmdv-xlbaohong') || Yii::$app->user->can('xuly-baohong')): ?>
                <?=  Html::a('Xử lý báo hỏng', ['xulybaohong', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('nhanvien-kd-baohong') & in_array($model->status, [1,3])): ?>
                <?=  Html::a('Phản hồi xử lý', ['phanhoixuly', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
            <?php endif; ?>
        </div>
            
        </div>
    </div>
</div>
