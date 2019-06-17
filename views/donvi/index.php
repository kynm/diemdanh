<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use app\models\Donvi;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DonviSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đơn vị chủ quản';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-index">
    <p>
        <?= (Yii::$app->user->can('create-donvi')) ? Html::a('<i class="fa fa-plus"></i> Thêm đơn vị', ['create'], ['class' => 'btn btn-primary btn-flat']) : ''?>
    </p>

    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'MA_DONVI',
                        'TEN_DONVI',
                        'DIA_CHI',
                        'SO_DT',
                        [
                            'attribute' => 'CAP_TREN',
                            'value' => 'cAPTREN.TEN_DONVI'
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                        'template' => (Yii::$app->user->can('edit-donvi')) ? '{view} {update} {delete}' : '{view}'],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>
