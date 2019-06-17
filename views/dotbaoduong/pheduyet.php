<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Noidungcongviec;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhanvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tổ trưởng giao việc';
$this->params['breadcrumbs'][] = ['label' => 'Đợt bảo dưỡng', 'url' => ['dotbaoduong/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="dotbaoduong-pheduyet">
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'responsiveWrap' => false,
                'floatHeader'=>true,
                'columns' => [
                    [
                        'attribute' => 'MA_DOTBD',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->MA_DOTBD, Url::to(['dotbaoduong/phancong', 'id' => $model->ID_DOTBD]));
                        }
                    ],
                    [
                        'attribute' => 'ID_TRAM',
                        'value' => 'tRAMVT.TEN_TRAM'
                    ],
                    [
                        'attribute' => 'NGAY_DUKIEN',
                        'format' => ['date', 'php:d/m/Y'],
                    ],
                    [
                        'attribute' => 'NGAY_KT_DUKIEN',
                        'format' => ['date', 'php:d/m/Y'],
                    ],
                    [
                        'attribute' => 'ID_BDT',
                        'value' => 'baoduongtong.MA_BDT'
                    ],
                    [
                        'attribute' => 'TTGV',
                        'value' => function ($model) {
                            $countAll = Noidungcongviec::find()->where(['ID_DOTBD' =>$model->ID_DOTBD])->count();
                            $count = Noidungcongviec::find()->where(['ID_DOTBD' =>$model->ID_DOTBD])->andWhere(['<>', 'ID_NHANVIEN', 0])->count();
                            return "$count / $countAll";
                        }
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>
