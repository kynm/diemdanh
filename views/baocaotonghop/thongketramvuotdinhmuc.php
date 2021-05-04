<?php

use yii\helpers\Html;
use app\models\Daivt;
use app\models\Tramvt;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Báo cáo theo định mức sử dụng điện trong tháng';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="tramvt-index">
    <div class="box box-primary">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['thongketramvuotdinhmuc'],
            ]); ?>
            <div class="col-md-2 col-xs-2">
                <?= Select2::widget([
                    'name' => 'ID_DONVI',
                    'id' => 'ID_DONVI',
                    'value' => $params['ID_DONVI'] ?? 2,
                    'data' => $dsdonvi,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Chọn đơn vị'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]); ?>
            </div>
            <div class="col-md-2 col-xs-2">
                <?= Select2::widget([
                    'name' => 'THANG',
                    'id' => 'THANG',
                    'value' => $params['THANG'] ? $params['THANG']  : 1,
                    'data' => $months,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Chọn tháng'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]); ?>
            </div>
            <div class="col-md-2 col-xs-2">
                <?= Select2::widget([
                    'name' => 'NAM',
                    'id' => 'NAM',
                    'value' => $params['NAM'],
                    'data' => $years,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Chọn năm'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]); ?>
            </div>
            <div class="col-md-2 col-xs-2">
                <label>Xuất excel</label>
                <input type="checkbox" name="is_excel" value="1">
            </div>
            <div class="col-md-2 col-xs-2">
                <label>Chỉ lấy vượt định mức</label>
                <input type="checkbox" name="is_dinhmuc" value="1" <?php echo $params['is_dinhmuc'] ? 'checked' : ''; ?>>
            </div>
            <div class="col-md-2 col-xs-2">
                <?= Html::submitButton(
                    '<i class="fa fa-search"></i> Xem báo cáo', 
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'searchBtn',
                        
                    ])
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên Đơn vị</th>
                        <th scope="col">Tên trạm</th>
                        <th scope="col">Định mức (KW)</th>
                        <th scope="col">Định mức (KW/h)</th>
                        <th scope="col">Lượng tiêu thụ (KW)</th>
                        <th scope="col">Giờ máy nổ</th>
                        <th scope="col">Máy nổ theo định mức điện(KW)</th>
                        <th scope="col">KW_THUCTE</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $tongthang1 = 0;
                        $i = 0;
                        foreach ($tongdien as $key => $value): $i ++;?>
                            <tr>
                                <td scope="col"><?php echo $i?></td>
                                <td scope="col"><?php echo $value['TEN_DONVI']?>
                                <td scope="col"><?php echo $value['TEN_TRAM']?>
                                <br><span style="font-size: 10px;"><?php echo $value['DIADIEM']?></span>
                                </td>
                                <td scope="col"><?php echo $value['DINHMUC']?></td>
                                <td scope="col"><?php echo formatnumber($value['DINHMUC_GIO'], 2)?></td>
                                <td scope="col"><?php echo formatnumber($value['KW_TIEUTHU'])?></td>
                                <td scope="col"><?php echo formatnumber($value['GIO_MAY_NO'], 2)?></td>
                                <td scope="col"><?php echo formatnumber($value['KW_MAY_NO'])?></td>
                                <td scope="col"><?php echo formatnumber($value['KW_THUCTE'])?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
