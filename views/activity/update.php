<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */

$this->title = 'Update Activity';
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->activity_type, 'url' => ['view', 'id' => $model->activity_type]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
