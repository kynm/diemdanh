<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý thiết bị theo trạm';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
                                'attribute' => 'ID_DAI',
                                'value' => 'iDDAI.TEN_DAIVT',
                                'filter'=>ArrayHelper::map(Daivt::find()->asArray()->all(), 'TEN_DAIVT', 'TEN_DAIVT'),
                            ],
                            [
                                'attribute' => 'TEN_TRAM',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->TEN_TRAM;
                                },
                                'filter'=>ArrayHelper::map(Tramvt::find()->asArray()->all(), 'TEN_TRAM', 'TEN_TRAM'),
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
