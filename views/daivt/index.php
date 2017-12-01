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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Thêm đài viễn thông', ['create'], ['class' => 'btn btn-success']) ?>
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
