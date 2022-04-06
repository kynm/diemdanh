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
                                    <th>ĐÃ LH, HẸN LÚC KHÁC</th>
                                    <th>ĐÃ THÊM VÀO NHÓM ZALO</th>
                                    <th>ĐÃ TƯ VẤN NGHIỆP VỤ</th>
                                    <th>ĐÃ GỬI DK01</th>
                                    <th>ĐÃ PHÁT HÀNH HĐ</th>
                                    <th>ĐÃ HD NGHIỆP VỤ SAU PHÁT HÀNH</th>
                                    <th>ĐÃ HỦY</th>
                                </tr>
                                <?php foreach ($dsketquachuyendoitheocongty as $key => $value):?>
                                    <tr>
                                        <td scope="col"><?php echo ($key + 1)?></td>
                                        <td scope="col"><?php echo $value['TEN_NHANVIEN']?>
                                        <td scope="col"><?php echo $value['DALH']?>
                                        <td scope="col"><?php echo $value['DATHEMZALO']?>
                                        <td scope="col"><?php echo $value['GUIDK01']?>
                                        <td scope="col"><?php echo $value['DAPHHD']?>
                                        <td scope="col"><?php echo $value['HDNVKHAC']?>
                                        <td scope="col"><?php echo $value['DADUNGDNK']?>
                                        <td scope="col"><?php echo $value['HUYDV']?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}'],
                        [
                            'attribute' => 'tt32to78_id',
                            'value' => 'khachhang.TEN_KH',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        [
                            'attribute' => 'nhanvien_id',
                            'value' => 'nhanvien.TEN_NHANVIEN'
                        ],
                        'ngay_tiepxuc',
                        [
                            'attribute' => 'ht_tc',
                            'value' => function ($model) {
                                return hinhthuctx()[$model->ht_tc];
                            }
                        ],
                        [
                            'attribute' => 'ketqua',
                            'value' => function ($model) {
                                return ketqua32to78()[$model->ketqua];
                            }
                        ],
                        'ghichu',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>