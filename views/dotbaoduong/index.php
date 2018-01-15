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

    
    

    <p>
        <?= Html::a('Thêm đợt bảo dưỡng', ['create'], ['class' => 'btn btn-primary']) ?>
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
                'value' => 'iDTRAMVT.MA_TRAM'
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
<?php Pjax::end(); ?></div>
