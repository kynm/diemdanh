<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileBaoduong */

$this->title = 'Create Profile Baoduong';
$this->params['breadcrumbs'][] = ['label' => 'Profile Baoduongs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-baoduong-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
