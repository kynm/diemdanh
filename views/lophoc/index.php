<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\lophocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QUẢN LÝ LỚP';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lophoc-index">
    <p>
        <?= (Yii::$app->user->can('create-lophoc')) ? Html::a('<i class="fa fa-plus"></i> Thêm lớp học', ['create'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
    </p>

    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'MA_LOP',
                        'TEN_LOP',
                        'DIA_CHI',
                        'SO_DT',
                        [
                            'attribute' => 'ID_DONVI',
                            'value' => 'iDDONVI.TEN_DONVI'
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => (Yii::$app->user->can('edit-lophoc')) ? '{view} {update} {delete}' : '{view}'
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
