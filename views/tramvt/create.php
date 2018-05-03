<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */

$this->title = 'Thêm trạm viễn thông';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị theo trạm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramvt-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
