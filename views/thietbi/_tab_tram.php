<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ThietbiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="thietbi-index">
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?> 
            <?= GridView::widget([
                'dataProvider' => $tramDataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'TEN_TRAM',
                    'DIADIEM',
                    [
                        'attribute' => 'ID_DAI',
                        'value' => 'iDDAI.TEN_DAIVT'
                    ],
                    [
                        'attribute' => 'ID_NHANVIEN',
                        'value' => 'iDNHANVIEN.TEN_NHANVIEN'
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>