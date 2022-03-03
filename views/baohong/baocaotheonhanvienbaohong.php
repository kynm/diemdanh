<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BÁO CÁO THEO NHÂN VIÊN XỬ LÝ';
?>
<div class="index">
    <div class="row">
        <?= $this->render('/partial/_link_search_with_date_type', [
            'url' => '/baohong/baocaotheonhanvienbaohong',
            'type' => $type,
        ]) ?>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>TÊN NHÂN VIÊN</th>
                                <th>CHƯA XỬ LÝ</th>
                                <th>CHƯA OUTBOUND</th>
                                <th>ĐÃ HOÀN THÀNH</th>
                                <th>TỔNG</th>
                            </tr>
                            <?php
                            $CHUA_XL = 0;
                            $CHUA_OUTBOUND = 0;
                            $HOANTHANH = 0;
                             foreach ($baocaotheonhanvienbaohong as $key => $value):
                                $CHUA_XL +=$value['CHUA_XL'];
                                $CHUA_OUTBOUND +=$value['CHUA_OUTBOUND'];
                                $HOANTHANH +=$value['HOANTHANH'];
                                ?>
                                <tr>
                                    <td scope="col"><?php echo ($key + 1)?></td>
                                    <td scope="col"><?php echo $value['TEN_NHANVIEN']?></td>
                                    <td scope="col"><?php echo $value['CHUA_XL']?></td>
                                    <td scope="col"><?php echo $value['CHUA_OUTBOUND']?></td>
                                    <td scope="col"><?php echo $value['HOANTHANH']?></td>
                                    <td scope="col"><?php echo $value['CHUA_XL'] + $value['CHUA_OUTBOUND'] + $value['HOANTHANH']?></td>
                                </tr>
                            <?php endforeach; ?>
                                <tr>
                                    <td scope="col"></td>
                                    <td scope="col">TỔNG</td>
                                    <td scope="col"><?php echo $CHUA_XL?></td>
                                    <td scope="col"><?php echo $CHUA_OUTBOUND?></td>
                                    <td scope="col"><?php echo $HOANTHANH?></td>
                                    <td scope="col"><?php echo $CHUA_XL + $CHUA_OUTBOUND + $HOANTHANH?></td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
