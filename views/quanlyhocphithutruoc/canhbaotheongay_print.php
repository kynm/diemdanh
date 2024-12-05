<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */
?>
<div class="box box-primary">
    <div class="box-body">
        <div class="box-body table-responsive">
            <div class="col-lg-12 col-12">
                <h3 class="text-center">DỮ LIỆU NGÀY <?= date('d/m/Y')?></h3>
                <table class="table table-bordered">
                    <tbody>
                        <tr class="bg-primary text-center">
                            <th class="text-center">STT</th>
                            <th class="text-center" style="width: 20%;">LỚP</th>
                            <th class="text-center" style="width: 20%;">HỌC SINH</th>
                            <th class="text-center">ĐIỆN THOẠI</th>
                            <th class="text-center">NGÀY BĐ</th>
                            <th class="text-center">NGÀY KT</th>
                            <th class="text-center">SỐ BUỔI ĐÃ HỌC</th>
                        </tr>
                        <?php
                        foreach ($result as $key => $value):
                        ?>
                        <tr style=" color: red;">
                            <td><?= $key + 1?></td>
                            <td><?= $value->lop->TEN_LOP?></td>
                            <td><?= $value->HO_TEN?></td>
                            <td><?= $value->SO_DT?></td>
                            <td><?= $value->NGAY_BD ? Yii::$app->formatter->asDatetime($value->NGAY_BD, 'php:d/m/Y') : null;?></td>
                            <td><?= $value->NGAY_KT ? Yii::$app->formatter->asDatetime($value->NGAY_KT, 'php:d/m/Y') : null;?></td>
                            <td><?= $value->getDsdiemdanh()->count()?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
