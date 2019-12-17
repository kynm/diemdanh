<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BaoduongtongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Baoduongtongs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="baoduongtong-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Baoduongtong', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID_BDT',
            'MA_BDT',
            'TYPE',
            'MO_TA',
            'TRANGTHAI',
            //'ID_NHANVIEN',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
