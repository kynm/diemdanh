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

/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '443 HNM - ' . $text;
?>
<div class="index">
    <div class="row">
        <div class="row">
            <div class="col-md-12">
                <div class="box-footer">
                    <div class="text-center">
                        <?= (Yii::$app->user->can('nhanvien-kd-baohong')) ? Html::a('<i class="fa fa-plus-square"></i>Tạo báo hỏng', ['/baohong/create'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3><b>Tổng hợp báo hỏng chưa Outbound</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Đơn vị</th>
                                    <th>Số lượng</th>
                                </tr>
                                <?php foreach ($dsbaohongchuaoutbound as $key => $value):?>
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
                        <h3><b>Tổng hợp báo hỏng chưa xử lý</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Đơn vị</th>
                                    <th>Số lượng</th>
                                </tr>
                                <?php foreach ($dsbaohongchuaxl as $key => $value):?>
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
            <div class="col-md-12">
                <div class="box-footer">
                    <div class="text-center">
                        <?= Html::a('Tháng trước', ['/?type=3'], ['class' => 'btn btn-danger btn-flat']) ?>
                        <?= Html::a('Hôm qua', ['/?type=1'], ['class' => 'btn btn-danger btn-flat']) ?>
                        <?= Html::a('Hôm nay', ['/?type=0'], ['class' => 'btn btn-danger btn-flat']) ?>
                        <?= Html::a('Tuần hiện tại', ['/?type=5'], ['class' => 'btn btn-danger btn-flat']) ?>
                        <?= Html::a('Tháng hiện tại', ['/?type=6'], ['class' => 'btn btn-danger btn-flat']) ?>
                        <?= Html::a('Năm hiện tại', ['/?type=8'], ['class' => 'btn btn-danger btn-flat']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3><b>Tổng hợp báo hỏng đã xử lý</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Đơn vị</th>
                                    <th>Số lượng</th>
                                </tr>
                                <?php foreach ($dsbaohongdaxl as $key => $value):?>
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
                        <h3><b>Báo hỏng theo dịch vụ</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Đơn vị</th>
                                    <th>Fiber</th>
                                    <th>MyTV</th>
                                    <th>Điện thoại cố định</th>
                                    <th>Di động</th>
                                </tr>
                                <?php foreach ($dsbaohongtheodichvu as $key => $value):?>
                                    <tr>
                                        <td scope="col"><?php echo ($key + 1)?></td>
                                        <td scope="col"><?php echo $value['TEN_DONVI']?>
                                        <td scope="col"><?php echo $value['FIBER']?>
                                        <td scope="col"><?php echo $value['MYTV']?>
                                        <td scope="col"><?php echo $value['DTCD']?>
                                        <td scope="col"><?php echo $value['DIDONG']?>
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
                        <h3><b>Báo hỏng theo nguyên nhân</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nguyên nhân</th>
                                    <th>Trung tâm VT Phủ Lý</th>
                                    <th>Trung tâm VT Bình Lục</th>
                                    <th>Trung tâm VT Duy Tiên</th>
                                    <th>Trung tâm VT Lý Nhân</th>
                                    <th>Trung tâm VT Kim Bảng</th>
                                    <th>Trung tâm VT Thanh Liêm</th>
                                </tr>
                                <?php foreach ($dsbaohongtheonguyennhan as $key => $value):?>
                                    <tr>
                                        <td scope="col"><?php echo ($key + 1)?></td>
                                        <td scope="col"><?php echo $value['nguyennhan']?>
                                        <td scope="col"><?php echo $value['PLY']?>
                                        <td scope="col"><?php echo $value['BLC']?>
                                        <td scope="col"><?php echo $value['DTN']?>
                                        <td scope="col"><?php echo $value['LNN']?>
                                        <td scope="col"><?php echo $value['KBG']?>
                                        <td scope="col"><?php echo $value['TLM']?>
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
