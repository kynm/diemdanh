<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Điều hành chiến dịch HDDT mới';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">

    <div class="box box-primary">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3><b>KẾT QUẢ CHUYỂN ĐỔI HÓA ĐƠN SANG TT 78(THEO LƯỢT CÔNG TY)</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-primary">
                                    <th style="width: 10px">#</th>
                                    <th>TÊN NHÂN VIÊN</th>
                                    <th>ĐÃ LH</th>
                                    <th>ĐÃ GỬI DK01 - HOÀN THÀNH NÂNG CẤP</th>
                                    <th>ĐÃ DÙNG DOANH NGHIỆP KHÁC</th>
                                    <th>ĐÃ HỦY</th>
                                    <th>GIẢI THỂ</th>
                                </tr>
                                <?php
                                $tongdalienhe = 0;
                                $tongdanangcap = 0;
                                $tongdadungdoanhnghiepkhac = 0;
                                $tongdahuy = 0;
                                $tonggiaithe = 0;
                                    ?>
                                <?php foreach ($dsketquachuyendoitheocongty as $key => $value):?>
                                    <?php
                                $tongdalienhe +=$value['TONG'];
                                $tongdanangcap += $value['GUIDK01'] + $value['DAPHHD'];
                                $tongdadungdoanhnghiepkhac += $value['DADUNGDNK'];
                                $tongdahuy += $value['HUYDV'];
                                $tonggiaithe += $value['GIAITHE'];
                                    ?>
                                    <tr>
                                        <td scope="col"><?php echo ($key + 1)?></td>
                                        <td scope="col"><?php echo $value['TEN_NHANVIEN']?></td>
                                        <td scope="col"><?php echo $value['TONG']?></td>
                                        <td scope="col"><?php echo ($value['GUIDK01'] + $value['DAPHHD'] + $value['HDNVKHAC'])?></td>
                                        <td scope="col"><?php echo $value['DADUNGDNK']?></td>
                                        <td scope="col"><?php echo $value['HUYDV']?></td>
                                        <td scope="col"><?php echo $value['GIAITHE']?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                        <td scope="col"><?php echo ($key + 1)?></td>
                                        <td scope="col"></td>
                                        <td scope="col"><?php echo $tongdalienhe?></td>
                                        <td scope="col"><?php echo $tongdanangcap?></td>
                                        <td scope="col"><?php echo $tongdadungdoanhnghiepkhac?></td>
                                        <td scope="col"><?php echo $tongdahuy?></td>
                                        <td scope="col"><?php echo $tonggiaithe?></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <div class="box-body">
            <?php Pjax::begin(); ?><?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'MST',
                            'value' => 'MST',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        [
                            'attribute' => 'tt32to78_id',
                            'value' => 'TEN_KH',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        'DIACHI',
                        [
                            'attribute' => 'nhanvien_id',
                            'value' => 'nhanvien.TEN_NHANVIEN'
                        ],
                        [
                            'attribute' => 'ketqua',
                            'value' => function ($model) {
                                return ketqua32to78()[$model->ketqua];
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'ghichu',
                            'value' => function ($model) {
                                return $model->ghichu;
                            },
                            // 'contentOptions' => ['style' => 'width:20%; white-space: normal;'],
                            'format' => 'raw',
                        ],
                        'ngay_lh',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>