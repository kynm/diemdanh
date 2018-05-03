<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Các đợt bảo dưỡng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dotbaoduong-index">

    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Thêm đợt bảo dưỡng', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
            </p>
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'MA_DOTBD',
                        'NGAY_BD',
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