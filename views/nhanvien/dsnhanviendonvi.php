<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhanvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'DANH SÁCH NHÂN VIÊN ĐƠN VỊ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    // 'formatter' => [
                    //     'class' => 'yii\i18n\Formatter',
                    //     'nullDisplay' => '',
                    // ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        // 'MA_NHANVIEN',
                        'TEN_NHANVIEN',
                        'DIEN_THOAI',
                        'USER_NAME',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>