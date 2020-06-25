<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Daivt;
use app\models\Nhanvien;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
$this->title = 'Nhật ký sử dụng máy nổ theo tổ quản lý';
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="tramvt-update">
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'USER_ID',
                            'value' => 'nGUOITAO.TEN_NHANVIEN'
                        ],
                        [
                            'attribute' => 'ID_NV_VANHANH',
                            'value' => 'nHANVIENVANHANH.TEN_NHANVIEN'
                        ],
                        [
                            'attribute' => 'ID_TRAM',
                            'value' => 'tRAMVANHANH.TEN_TRAM'
                        ],
                        [
                            'attribute' => 'THOIGIANBATDAU',
                            // 'format' => ['date', 'php:d/m/Y H:i'],
                        ],
                        [
                            'attribute' => 'THOIGIANKETTHUC',
                            // 'format' => ['date', 'php:d/m/Y H:i'],
                        ],
                        'DINHMUC',
                        [
                            'attribute' => 'hous',
                        ],
                        [
                            'attribute' => 'soluong',
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>