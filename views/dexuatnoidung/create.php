<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dexuatnoidung */

$this->title = 'Thêm đề xuất';
$this->params['breadcrumbs'][] = ['label' => 'Dexuatnoidungs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dexuatnoidung-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
