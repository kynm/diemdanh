<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Trangthailophoc;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\lophocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BẢNG TỔNG HỢP LỊCH HỌC CỐ ĐỊNH';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lophoc-index">
    <p>
        <?= $this->render('/partial/_header_quanlylichhoc', []) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <div class="box-body table-responsive">
                <div class="col-lg-12 col-12">
                    <table class="table table-bordered" style="font-size: 20px;">
                        <tbody>
                            <tr class="bg-primary text-center">
                                <th class="text-center">STT</th>
                                <th class="text-center">LỚP</th>
                                <th class="text-center">THỨ 2</th>
                                <th class="text-center">THỨ 3</th>
                                <th class="text-center">THỨ 4</th>
                                <th class="text-center">THỨ 5</th>
                                <th class="text-center">THỨ 6</th>
                                <th class="text-center">THỨ 7</th>
                                <th class="text-center">CHỦ NHẬT</th>
                            </tr>
                            <?php
                            foreach ($dslop as $key => $lophoc):
                            ?>
                            <tr>
                                <td><?= $key + 1?></td>
                                <td><?= $lophoc->TEN_LOP?></td>
                                <td class="text-center"><?= in_array(1, explode(',', $lophoc->ds_lichcodinh)) ? 'x' : ''?></td>
                                <td class="text-center"><?= in_array(2, explode(',', $lophoc->ds_lichcodinh)) ? 'x' : ''?></td>
                                <td class="text-center"><?= in_array(3, explode(',', $lophoc->ds_lichcodinh)) ? 'x' : ''?></td>
                                <td class="text-center"><?= in_array(4, explode(',', $lophoc->ds_lichcodinh)) ? 'x' : ''?></td>
                                <td class="text-center"><?= in_array(5, explode(',', $lophoc->ds_lichcodinh)) ? 'x' : ''?></td>
                                <td class="text-center"><?= in_array(6, explode(',', $lophoc->ds_lichcodinh)) ? 'x' : ''?></td>
                                <td class="text-center"><?= in_array(0, explode(',', $lophoc->ds_lichcodinh)) ? 'x' : ''?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
JS;
$this->registerJs($script);
?>