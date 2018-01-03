<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DaivtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đài viễn thông';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-index">

    <p>
        <?= Html::a('Thêm đài viễn thông', ['create'], ['class' => 'btn btn-primary']) ?>
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
