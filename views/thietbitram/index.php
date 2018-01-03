<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ThietbitramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thiết bị tại trạm';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbitram-index">

    
    

    <p>
        <?= Html::a('Thêm mới thiết bị trạm', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'ID_LOAITB',
                'value' => 'iDLOAITB.TEN_THIETBI'
            ],
            [
                'attribute' => 'ID_TRAM',
                'value' => 'iDTRAM.MA_TRAM'
            ],
            'LANBAODUONGTRUOC',
            'LANBAODUONGTIEP',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
