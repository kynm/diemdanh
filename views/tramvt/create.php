<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */

$this->title = 'Thêm trạm viễn thông';
$this->params['breadcrumbs'][] = ['label' => 'Tramvts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramvt-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
