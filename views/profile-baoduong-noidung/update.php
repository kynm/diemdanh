<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileBaoduongNoidung */

$this->title = 'Update Profile Baoduong Noidung: ' . $model->ID_PROFILE;
$this->params['breadcrumbs'][] = ['label' => 'Profile Baoduong Noidungs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_PROFILE, 'url' => ['view', 'ID_PROFILE' => $model->ID_PROFILE, 'MA_NOIDUNG' => $model->MA_NOIDUNG]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-baoduong-noidung-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
