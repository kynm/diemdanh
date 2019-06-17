<?php

use yii\helpers\Html;
use app\models\Thietbi;

/* @var $this yii\web\View */
/* @var $model app\models\Noidungbaotri */

$this->title = 'Thêm nội dung';
if (isset($_GET['id'])) {
	$thietbi = Thietbi::findOne($_GET['id']);
	$this->params['breadcrumbs'][] = ['label' => 'Nhóm thiết bị', 'url' => ['nhomtbi/index']];
	$this->params['breadcrumbs'][] = ['label' => $thietbi->iDNHOM->TEN_NHOM, 'url' => ['nhomtbi/view', 'id' => $thietbi->ID_NHOM]];
	$this->params['breadcrumbs'][] = ['label' => $thietbi->TEN_THIETBI, 'url' => ['thietbi/view', 'id' => $thietbi->ID_THIETBI]];
} else {
	$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
	$this->params['breadcrumbs'][] = ['label' => 'Nội dung bảo trì', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noidungbaotri-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
