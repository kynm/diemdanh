<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Hocsinh;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'CHI TIẾT HỌC PHÍ THEO LỚP';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box-body table-responsive">
	<h2 class="text-center"><b>LỚP <?= mb_strtoupper($model->lop->TEN_LOP)?></b>
    <h3 class="text-center"><?= dateofmonth()[date_format(date_create($model->NGAY_DIEMDANH), 'w')] ?></h3>
    <h6>SỐ HỌC CỦA LỚP: <?= $model->getDschitietdiemdanh()->count()?></h6>
    <h6>SỐ HỌC SINH ĐI HỌC: <?= $model->getDschitietdiemdanh()->andWhere(['STATUS' => 1])->count()?></h6>
    <h6>SỐ HỌC SINH NGHỈ<?= $model->getDschitietdiemdanh()->andWhere(['STATUS' => 0])->count()?></h6>
    <h6><?php $idhocsinh = ArrayHelper::map($model->getDschitietdiemdanh()->andWhere(['STATUS' => 0])->all(), 'ID_HOCSINH', 'ID_HOCSINH');
        $dshocsinhvang = ArrayHelper::map(Hocsinh::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['in', 'ID', $idhocsinh])->all(), 'ID', 'HO_TEN');
        echo $dshocsinhvang ? implode(',', $dshocsinhvang) : null;?></h6>
    <div>Nội dung buổi học</div>
    <h3 class="text-center">NỘI DUNG BUỔI HỌC</h3>
    <div><?= nl2br($model->NOIDUNG)?></div>
    <h3 class="text-center">GHI CHÚ</h3>
    <div><?= nl2br($model->ghichu)?></div>
    </h2>
</div>