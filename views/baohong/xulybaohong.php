<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Báo hỏng';
$this->params['breadcrumbs'][] = ['label' => 'Báo hỏng', 'url' => ['baohong/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?php if (in_array($model->status, [0,2])): ?>
        <div class="xuly-baohong">
        <?= $this->render('_form_xl_baohong', [
            'model' => $model,
            'dsNhanvien' => $dsNhanvien,
        ]) ?>
    <?php endif; ?>
    <div class="box box-primary">
        <div class="box-body">
            <?= $this->render('_detail', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
</div>
