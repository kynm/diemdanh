<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NoidungbaotriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nội dung bảo dưỡng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noidungbaotri-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Thêm nội dung bảo dưỡng', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'MA_NOIDUNG',
            ['attribute' => 'ID_THIETBI', 'value' => 'iDTHIETBI.TEN_THIETBI'],
            'NOIDUNG',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
