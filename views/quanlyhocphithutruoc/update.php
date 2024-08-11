<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'CHỈNH SỬA HỌC PHÍ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-update">

    <?= $this->render('_form_update', [
        'model' => $model,
        'dslop' => $dslop,
    ]) ?>

</div>
