<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Tạo mới';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/partial/_header_quanlyhocphi', []) ?>
<div class="daivt-create">

    <?= $this->render('_form_multiple', [
        'model' => $model,
        'dslop' => $dslop,
    ]) ?>

</div>
