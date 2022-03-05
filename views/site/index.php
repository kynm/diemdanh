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
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3><b>BÁO HỎNG CHƯA XỬ LÝ</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-danger">
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
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3><b>BÁO HỎNG CHƯA OUTBOUND</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-warning">
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
            <?php if(Yii::$app->user->can('create-tinnhandieuhanh')) { ?>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3><b>TIN NHẮN ĐIỀU HÀNH</b></h3>
                    </div>
                    <div class="box-body">
                        <?php $form = ActiveForm::begin([
                            'method' => 'post',
                            'action' => ['/site/tinnhandieuhanh'],
                        ]); ?>
                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4 col-xs-4">
                                        <div class="form-group">
                                            <?php foreach ($dsDonvi as $key => $value) {?>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" value="<?php echo $key?>" name="donvi_id[]" checked="checked"><?php echo $value?></label>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <div class="form-group field-election-election_description">
                                        <label class="control-label" for="election-election_description">Nội dung</label>
                                        <textarea id="election-election_description" class="form-control" name="noidung" rows="6"></textarea>    
                                        <div class="help-block"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="box-footer">
                                <div class="text-center">
                                    <?= Html::submitButton('<i class="fa fa-plus"></i> Gửi tin nhắn', ['class' => 'btn btn-primary btn-flat', 'id' => 'submit-form']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?= $this->render('/partial/_link_search_with_date_type', [
                'url' => '/',
                'type' => $type,
            ]) ?>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3><b>BÁO HỎNG ĐÃ XỬ LÝ</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-primary">
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
                        <h3><b>BÁO HỎNG THEO DỊCH VỤ</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-primary">
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
                        <h3><b>BÁO HỎNG THEO NGUYÊN NHÂN</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-primary">
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
