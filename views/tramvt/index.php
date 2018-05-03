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
    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= (Yii::$app->user->can('create-tramvt')) ? Html::a('<i class="fa fa-plus"></i> Thêm trạm viễn thông', ['create'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
            </p>
            <?php Pjax::begin(); ?>    
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'MA_TRAM',
                        'DIADIEM',
                        [
                            'attribute' => 'ID_DAI',
                            'value' => 'iDDAI.TEN_DAIVT'
                        ],
                        [
                            'attribute' => 'ID_NHANVIEN',
                            'value' => 'iDNHANVIEN.TEN_NHANVIEN'
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