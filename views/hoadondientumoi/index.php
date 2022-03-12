<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Điều hành chiến dịch HDDT mới';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <p>
        <?= (Yii::$app->user->can('import-dshddtmoi')) ? Html::a('<i class="fa fa-plus"></i> Import dữ liệu', ['import'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
        <?= Html::a('Lịch sử tiếp xúc', ['lichsutiepxuc'], ['class' => 'btn btn-primary btn-flat']) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}'],
                        [
                            'attribute' => 'TEN_KH',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        'MST',
                        [
                            'attribute' => 'DIACHI',
                            'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        ],
                        'LIENHE',
                        'EMAIL',
                        'ngay_lh',
                        [
                            'attribute' => 'donvi_id',
                            'value' => 'donvi.TEN_DONVI'
                        ],
                        
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            
        </div>
    </div>
</div>