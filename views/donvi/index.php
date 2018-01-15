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
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-index">

    <p>
        <?php
            Modal::begin([
            'toggleButton' => [
                'label' => '<i class="glyphicon glyphicon-plus"></i> Thêm mới',
                'class' => 'btn btn-primary'
            ],
                'size' => 'modal-lg',
            ]);
            $model = new Donvi();
            echo $this->render('_form', [
                'model' => $model,
            ]);
            Modal::end(); 
            //Html::a('Thêm đơn vị chủ quản', ['create'], ['class' => 'btn btn-primary']) 
        ?>
    </p>
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
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
