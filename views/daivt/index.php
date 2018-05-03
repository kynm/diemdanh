<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DaivtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đài viễn thông';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-index">

    <div class="box box-primary">
        <div class="box-body">
        <p>
            <?= (Yii::$app->user->can('create-daivt')) ? Html::a('<i class="fa fa-plus"></i> Thêm đài viễn thông', ['create'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
        </p>
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'MA_DAIVT',
                        'TEN_DAIVT',
                        'DIA_CHI',
                        'SO_DT',
                        [
                            'attribute' => 'ID_DONVI',
                            'value' => 'iDDONVI.TEN_DONVI'
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => (Yii::$app->user->can('edit-daivt')) ? '{view} {update} {delete}' : '{view}'
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
