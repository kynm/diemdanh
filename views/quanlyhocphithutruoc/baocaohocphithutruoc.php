<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'BÁO CÁO THU HỌC PHÍ';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('/partial/_header_hocphithutruoc', []) ?>
<div class="row">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
    ]); ?>
    <div class="col-sm-3">
        <label class="control-label">Từ ngày</label>
        <?=
         DatePicker::widget([
            'attribute' => 'TU_NGAY',
            'name' => 'TU_NGAY',
            'value' => $params['TU_NGAY'] ?? null,
            'removeButton' => false,
            'options' => ['required' => true],
            'pluginOptions' => [
                'placeholder' => 'TỪ NGÀY', 
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ],
            'pluginEvents' => ['changeDate' => "function(e){
               $(e.target).closest('form').submit();
            }"],
        ]); ?>
    </div>

    <div class="col-sm-3">
        <label class="control-label">Đến ngày</label>
        <?= DatePicker::widget([
            'attribute' => 'DEN_NGAY',
            'name' => 'DEN_NGAY', 
            'value' => $params['DEN_NGAY'] ?? null,
            'removeButton' => false,
            'options' => ['placeholder' => 'ĐẾN NGÀY', 'required' => true, 'allowClear' => true],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ],
            'pluginEvents' => ['changeDate' => "function(e){
               $(e.target).closest('form').submit();
            }"],
        ]); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="box-body table-responsive">
    </h2>
    <div class="col-lg-12 col-12">
        <table class="table table-bordered">
            <tbody>
                <tr class="bg-primary text-center">
                    <th class="text-center">LỚP</th>
                    <th class="text-center">SỐ HỌC SINH</th>
                    <th class="text-center">SỐ LƯỢT</th>
                    <th class="text-center">CHƯA THU</th>
                    <th class="text-center">ĐÃ THU</th>
                    <th class="text-center">TỔNG TIỀN</th>
                    <th class="text-center">TỔNG TIỀN CHƯA THU</th>
                    <th class="text-center">TỔNG TIỀN ĐÃ THU</th>
                    <th class="text-center"></th>
                </tr>
                <?php
                $TONGSO_HS = 0;
                $TONGSOLUONG = 0;
                $TONGDA_DONG = 0;
                $TONGCHUA_DONG = 0;
                $TONGTONGTIEN = 0;
                $TONGTIEN_CHUA_DONG = 0;
                $TONGTIEN_DA_DONG = 0;
                foreach ($result as $key => $value):
                    $TONGSO_HS += $value['SO_HS'];
                    $TONGSOLUONG += $value['SOLUONG'];
                    $TONGDA_DONG += $value['DA_DONG'];
                    $TONGCHUA_DONG += $value['CHUA_DONG'];
                    $TONGTONGTIEN += $value['TONGTIEN'];
                    $TONGTIEN_CHUA_DONG += $value['TIEN_CHUA_DONG'];
                    $TONGTIEN_DA_DONG += $value['TIEN_DA_DONG'];
                ?>
                <tr class="text-center">
                    <td><?= $value['TEN_LOP']?></td>
                    <td class="text-center"><?= number_format($value['SO_HS'])?></td>
                    <td class="text-center"><?= number_format($value['SOLUONG'])?></td>
                    <td class="text-center"><?= number_format($value['CHUA_DONG'])?></td>
                    <td class="text-center"><?= number_format($value['DA_DONG'])?></td>
                    <td class="text-center"><?= number_format($value['TONGTIEN'])?></td>
                    <td class="text-center"><?= number_format($value['TIEN_CHUA_DONG'])?></td>
                    <td class="text-center"><?= number_format($value['TIEN_DA_DONG'])?></td>
                    <td class="text-center"></td>
                </tr>
                <?php endforeach; ?>
                <tr class="text-center" style="color: red;font-size: 20px;">
                    <td>TỔNG</td>
                    <td class="text-center"><?= number_format($TONGSO_HS)?></td>
                    <td class="text-center"><?= number_format($TONGSOLUONG)?></td>
                    <td class="text-center"><?= number_format($TONGDA_DONG)?></td>
                    <td class="text-center"><?= number_format($TONGCHUA_DONG)?></td>
                    <td class="text-center"><?= number_format($TONGTONGTIEN)?></td>
                    <td class="text-center"><?= number_format($TONGTIEN_CHUA_DONG)?></td>
                    <td class="text-center"><?= number_format($TONGTIEN_DA_DONG)?></td>
                    <td class="text-center"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
