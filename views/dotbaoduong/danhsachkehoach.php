<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\Dotbaoduong;
use app\models\Nhanvien;
use app\models\Tramvt;
use kartik\select2\Select2;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\KehoachbdtbSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kế hoạch';
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['danhsachkehoach']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kehoachbdtb-index">
    <div class="box box-primary">
        <div class="box-body">
            
            <?php Pjax::begin(); ?>    
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'MA_DOTBD',
                        [
                            'attribute' => 'NGAY_BD',
                            'format' => ['date', 'php:d/m/Y'],
                        ],
                        [
                            'attribute' => 'ID_TRAMVT',
                            'value' => 'tRAMVT.MA_TRAM'
                        ],
                        [
                            'attribute' => 'TRUONG_NHOM',
                            'value' => 'tRUONGNHOM.TEN_NHANVIEN'
                        ],
                        'TRANGTHAI',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => Yii::$app->user->can('edit-dbd') ? '{view} {update} {delete}' : '{view}',
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>