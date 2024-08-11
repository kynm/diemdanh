<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Thêm điểm danh thủ công';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'lớp học', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-create">

    <?= $this->render('_form_diemdanhthucong', [
        'model' => $diemdanh,
        'dshocsinh' => $dshocsinh,
    ]) ?>

</div>
