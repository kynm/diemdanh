<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
// $this->title = 'NHập hợp dồng ' . $tramvt->TEN_TRAM . $tramvt->MA_TRAM;
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="hopdong-update">
    <?= $this->render('_form_phieuthu', [
        'model' => $model,
    ]) ?>
</div>