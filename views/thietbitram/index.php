<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ThietbitramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thiết bị trạm';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbitram-index">
    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Thêm thiết bị trạm', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
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

                        ['class' => 'yii\grid\ActionColumn',
                        'template' => (Yii::$app->user->can('edit-tbitram')) ? '{view} {update} {delete}' : '{view}'],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
