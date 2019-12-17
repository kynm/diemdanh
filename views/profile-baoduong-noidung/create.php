<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileBaoduongNoidung */

$this->title = 'Create Profile Baoduong Noidung';
$this->params['breadcrumbs'][] = ['label' => 'Profile Baoduong Noidungs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-baoduong-noidung-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
