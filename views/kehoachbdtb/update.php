<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kehoachbdtb */

$this->title = 'Update Kehoachbdtb: ' . $model->ID_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Kehoachbdtbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DOTBD, 'url' => ['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kehoachbdtb-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
