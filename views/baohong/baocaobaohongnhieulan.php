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

$this->title = 'BÁO CÁO THUÊ BAO BÁO HỎNG NHIỀU LẦN';
?>
<div class="index">
    <div class="row">
        <?= $this->render('/partial/_link_search_with_date_type', [
            'url' => '/baohong/baocaobaohongnhieulan',
            'type' => $type,
        ]) ?>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>TÊN ĐƠN VỊ</th>
                                <th>MÃ THUÊ BAO</th>
                                <th>SỐ LƯỢNG</th>
                            </tr>
                            <?php
                             foreach ($baocaobaohongnhieulan as $key => $value):
                                ?>
                                <tr>
                                    <td scope="col"><?php echo ($key + 1)?></td>
                                    <td scope="col"><?php echo $value['TEN_DONVI']?></td>
                                    <td scope="col"><?php echo $value['MA_TB']?></td>
                                    <td scope="col"><?php echo $value['SO_LUONG']?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
