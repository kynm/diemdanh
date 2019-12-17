<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileBaoduongNoidung */

$this->title = $model->ID_PROFILE;
$this->params['breadcrumbs'][] = ['label' => 'Profile Baoduong Noidungs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-baoduong-noidung-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID_PROFILE' => $model->ID_PROFILE, 'MA_NOIDUNG' => $model->MA_NOIDUNG], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID_PROFILE' => $model->ID_PROFILE, 'MA_NOIDUNG' => $model->MA_NOIDUNG], [
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
            'ID_PROFILE',
            'MA_NOIDUNG',
        ],
    ]) ?>

</div>
