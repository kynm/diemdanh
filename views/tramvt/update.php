<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Daivt;
use app\models\Nhanvien;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */

$this->title = 'Cập nhật trạm ' . $model->TEN_TRAM;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị theo trạm', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Trạm '.$model->TEN_TRAM, 'url' => ['view', 'id' => $model->ID_TRAM]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="tramvt-update">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>