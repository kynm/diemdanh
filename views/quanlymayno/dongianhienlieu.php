<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý thiết giá nhiên liệu';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= (Yii::$app->user->can('create-gianhienlieu')) ? Html::a('<i class="fa fa-plus"></i> Thêm giá nhiên liệu', ['creategianhienlieu'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
</p>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'LOAI_NHIENLIEU',
                                'value' => 'LOAI_NHIENLIEU'
                            ],
                            [
                                'attribute' => 'THANG',
                                'value' => 'THANG'
                            ],
                            [
                                'attribute' => 'NAM',
                                'value' => 'NAM'
                            ],
                            [
                                'attribute' => 'DONGIA',
                                'value' => 'DONGIA'
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template'=>'{view}',
                                'buttons'=>[
                                ]  
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
