<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý thiết bị theo trạm';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramvt-index">   
    <p>
        <?= (Yii::$app->user->can('create-tramvt')) ? Html::a('<i class="fa fa-plus"></i> Thêm trạm viễn thông', ['create'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        // 'options' => [
                        //     'class' => 'table-responsive',
                        // ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'MA_CSHT',
                            [
                                'attribute' => 'TEN_TRAM',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::a($model->TEN_TRAM, Url::to(['tramvt/view', 'id' => $model->ID_TRAM]));
                                }
                            ],
                            'DIADIEM',
                            [
                                'attribute' => 'ID_DAI',
                                'value' => 'iDDAI.TEN_DAIVT'
                            ],
                            [
                                'attribute' => 'ID_NHANVIEN',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->iDNHANVIEN ? Html::a($model->iDNHANVIEN->TEN_NHANVIEN, Url::to(['nhanvien/view', 'id' => $model->ID_NHANVIEN])) : '#';
                                }
                            ],
                            [
                                'attribute' => 'LOAITRAM',
                                'value' => 'loaihinhcsht.TEN_LOAIHINH_CSHT'
                            ],
                            [
                                'attribute' => 'TRANGTHAI_CSHT_ID',
                                'value' => 'trangthaicsht.TEN_TRANGTHAI_CSHT'
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                // 'template' => 
                                'visibleButtons' => [
                                    'update' => function ($model) {
                                        if (Yii::$app->user->can('edit-tramvt')) {
                                            switch (Yii::$app->user->identity->nhanvien->chucvu->cap) {
                                                case '1':
                                                    return true;
                                                    break;
                                                case '2':
                                                    if ($model->iDDAI->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                                                        return true;
                                                    }
                                                    break;
                                                case '3':
                                                    if ($model->ID_DAI == Yii::$app->user->identity->nhanvien->ID_DAI) {
                                                        return true;
                                                    }
                                                    break;
                                                case '4':
                                                    if ($model->ID_NHANVIEN == Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
                                                        return true;
                                                    }
                                                    break;
                                                case '5':
                                                    if ($model->ID_DAI == Yii::$app->user->identity->nhanvien->ID_DAI) {
                                                        return true;
                                                    }
                                                    break;
                                                
                                                default:
                                                    return false;
                                                    break;
                                            }
                                        } else {
                                            return false;
                                        }
                                    },
                                    'delete' => function ($model) {
                                        if (Yii::$app->user->can('delete-tramvt')) {
                                            switch (Yii::$app->user->identity->nhanvien->chucvu->cap) {
                                                case '1':
                                                    return true;
                                                    break;
                                                case '2':
                                                    if ($model->iDDAI->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                                                        return true;
                                                    }
                                                    break;
                                                case '3':
                                                    if ($model->ID_DAI == Yii::$app->user->identity->nhanvien->ID_DAI) {
                                                        return true;
                                                    }
                                                    break;
                                                case '4':
                                                    if ($model->ID_NHANVIEN == Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
                                                        return true;
                                                    }
                                                    break;
                                                case '5':
                                                    if ($model->ID_DAI == Yii::$app->user->identity->nhanvien->ID_DAI) {
                                                        return true;
                                                    }
                                                    break;
                                                
                                                default:
                                                    return false;
                                                    break;
                                            }
                                        } else {
                                            return false;
                                        }
                                    },
                                ]
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
