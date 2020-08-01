<?php

use yii\helpers\Html;
use app\models\Daivt;
use app\models\Tramvt;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Các trạm chưa map dữ liệu';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="tramvt-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Tên đơn vị</th>
                        <th scope="col">Tháng</th>
                        <th scope="col">Mã điện lực</th>
                        <th scope="col">Mã CSHT</th>
                      </tr>
                    </thead>
                    <tbody>

                        <?php 
                        foreach ($data1 as $key => $value): ?>
                      <tr>
                        <th scope="col"><?php echo $value['tendv'];?></th>
                        <th scope="col"><?php echo $value['THANG'];?></th>
                        <th scope="col"><?php echo $value['ma_dienluc'];?></th>
                        <th scope="col"><?php echo $value['ma_csht'];?></th>
                    </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
