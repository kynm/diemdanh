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
                            <th class="text-center">SỐ BUỔI ĐÃ THU TIỀN</th>
                            <th class="text-center">SỐ BUỔI ĐÃ HỌC</th>
                            <th class="text-center">SỐ BUỔI CÒN LẠI</th>
                        </tr>
                        <?php
                        foreach ($result as $key => $value):
                        ?>
                        <tr style=" color: <?= $value['SOBUOI_CONLAI'] < 1 ? 'red;' : ''?>;">
                            <td><?= $key + 1?></td>
                            <td><?= $value['TEN_LOP']?></td>
                            <td><?= ($value['HO_TEN'])?></td>
                            <td class="text-center"><?= number_format($value['SOLUONG_DADONGTIEN'])?></td>
                            <td class="text-center"><?= number_format($value['SOLUONG_DAHOC'])?></td>
                            <td class="text-center"><?= number_format($value['SOBUOI_CONLAI'])?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
