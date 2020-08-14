<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý phiếu thu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="phieuthu-index">
    <p>
        <?= (Yii::$app->user->can('create-phieuthu-qlhopdong')) ? Html::a('<i class="fa fa-plus"></i> Thêm phiếu thu', ['create-phieuthu', 'idHopdong' => $hopdong->ID], ['class' => 'btn btn-primary btn-flat']) : ''?>
    </p>
    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Back', ['view', 'MA_CSHT' => $hopdong->MA_CSHT], ['class' => 'btn btn-primary btn-flat'])?>
    </p>
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
                                'attribute' => 'ID_HOPDONG',
                                'value' => 'hopdong.MA_HOPDONG',
                            ],
                            'TUNGAY',
                            'DENNGAY',
                            'SOTHANG',
                            'GIATIEN',
                            'VAT',
                            'TONGTIEN',
                            'LOAI_CHUNGTU',
                            'TEN_NGUOINHAN',
                            'TRANGTHAI',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '',
                                'buttons' => [
                                ],
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
