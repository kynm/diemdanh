<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Thêm đài viễn thông';
$this->params['breadcrumbs'][] = ['label' => 'Daivts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
