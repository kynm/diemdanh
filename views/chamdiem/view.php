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
	<h2 class="text-center"><b>LỚP <?= mb_strtoupper($model->lop->TEN_LOP)?></b></h2>
    <h3 class="text-center"><?= dateofmonth()[date_format(date_create($model->NGAY_CHAMDIEM), 'w')] ?></h3>
    <?php if($model->NOIDUNG) :?>
        <h3 class="text-center">NỘI DUNG BUỔI HỌC</h3>
        <div><?= nl2br($model->NOIDUNG)?></div>
    <?php endif; ?>
    <div class="box-body table-responsive">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr class="bg-primary text-center">
                        <th class="text-center">STT</th>
                        <th class="text-center">Học sinh</th>
                        <th class="text-center">Điểm</th>
                        <th class="text-center">Nhận xét</th>
                    </tr>
                    <?php foreach ($dschitietchamdiem as $key => $value): ?>
                    <tr>
                        <td><?= $key + 1?></td>
                        <td><?= $value->hocsinh->HO_TEN?></td>
                        <td class="text-center"><?= $value->DIEM?></td>
                        <td><?= $value->NHAN_XET?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>