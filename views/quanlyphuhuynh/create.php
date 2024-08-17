<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Nhanvien */

$this->title = 'Thêm phụ huynh';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if (isset($errors)) {
    foreach ($errors as $key => $value) {
        die(var_dump($value));
    ?>
    <p></p>
<?php }} ?>
<div class="nhanvien-create">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>
