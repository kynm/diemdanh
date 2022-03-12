<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dosamigos\chartjs\ChartJs;
use app\models\ActivitiesLog;
use app\models\Baoduongtong;
use app\models\Daivt;
use app\models\Donvi;
use app\models\Dotbaoduong;
use app\models\Images;
use app\models\Nhomtbi;
use app\models\Noidungcongviec;
use app\models\Tramvt;
$dsDonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', [2,3,4,5,6,7]])->all(), 'ID_DONVI', 'TEN_DONVI');

/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'RA QUÂN - ' . $text;
?>
<div class="index">
    <div class="row">
        <div class="row">
            <?= $this->render('/partial/_link_search_with_date_type', [
                'url' => '/',
                'type' => $type,
            ]) ?>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3><b>KHÁCH HÀNG ĐÃ TIẾP CẬN THEO ĐỊA BÀN</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-primary">
                                    <th style="width: 10px">#</th>
                                    <th>Đơn vị</th>
                                    <th>Số lượng</th>
                                </tr>
                                <?php foreach ($tongkhdatiepcan as $key => $value):?>
                                    <tr>
                                        <td scope="col"><?php echo ($key + 1)?></td>
                                        <td scope="col"><?php echo $value['TEN_DONVI']?>
                                        <td scope="col"><?php echo $value['SO_LUONG']?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3><b>HÌNH THỨC TIẾP CẬN</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-primary">
                                    <th style="width: 10px">#</th>
                                    <th>ĐỊA BÀN</th>
                                    <th>GỌI ĐIỆN</th>
                                    <th>GẶP TRỰC TIẾP</th>
                                </tr>
                                <?php foreach ($cachtiepcan as $key => $value):?>
                                    <tr>
                                        <td scope="col"><?php echo ($key + 1)?></td>
                                        <td scope="col"><?php echo $value['TEN_DONVI']?>
                                        <td scope="col"><?php echo $value['GOIDIEN']?>
                                        <td scope="col"><?php echo $value['GAPTRUCTIEP']?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3><b>KẾT QUẢ TIẾP CẬN</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-primary">
                                    <th style="width: 10px">#</th>
                                    <th>ĐỊA BÀN</th>
                                    <th>ĐỒNG Ý</th>
                                    <th>KÝ HỢP ĐỒNG</th>
                                    <th>THU TIỀN</th>
                                    <th>ĐÃ HOÀN THIỆN</th>
                                    <th>ĐÃ DÙNG TRƯỚC</th>
                                    <th>ĐÃ DÙNG DN KHÁC</th>
                                    <th>GIẢI THỂ</th>
                                    <th>SÁT NHẬP</th>
                                    <th>HẸN GỌI SAU</th>
                                </tr>
                                <?php foreach ($dsketquatiepcan as $key => $value):?>
                                    <tr>
                                        <td scope="col"><?php echo ($key + 1)?></td>
                                        <td scope="col"><?php echo $value['TEN_DONVI']?>
                                        <td scope="col"><?php echo $value['DONGY']?>
                                        <td scope="col"><?php echo $value['KYHOPDONG']?>
                                        <td scope="col"><?php echo $value['THUTIEN']?>
                                        <td scope="col"><?php echo $value['HOANTHIEN']?>
                                        <td scope="col"><?php echo $value['DADUNGTRUOC']?>
                                        <td scope="col"><?php echo $value['DADUNGDNK']?>
                                        <td scope="col"><?php echo $value['GIAITHE']?>
                                        <td scope="col"><?php echo $value['SATNHAP']?>
                                        <td scope="col"><?php echo $value['HENGOISAU']?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
