<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Kehoachbdtb */

$this->title = 'Create Kehoachbdtb';
$this->params['breadcrumbs'][] = ['label' => 'Kehoachbdtbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kehoachbdtb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
