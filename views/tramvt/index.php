<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trạm viễn thông';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramvt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Thêm trạm viễn thông', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'MA_TRAM',
            'DIADIEM',
            [
                'attribute' => 'ID_DAIVT',
                'value' => 'iDDAIVT.TEN_DAIVT'
            ],
            [
                'attribute' => 'ID_NHANVIEN',
                'value' => 'iDNHANVIEN.TEN_NHANVIEN'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
