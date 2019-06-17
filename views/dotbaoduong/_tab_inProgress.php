<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use app\models\Images;
use app\models\Noidungcongviec;
?>
<div class="table-responsive">
<?php
Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $inprogressProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'MA_DOTBD',
            [
                'attribute' => 'ID_TRAM',
                'value' => 'tRAMVT.TEN_TRAM'
            ],
            [
                'attribute' => 'NGAY_BD',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'NGAY_KT_DUKIEN',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'ID_NHANVIEN',
                'value' => 'nHANVIEN.TEN_NHANVIEN'
            ],
            [
                'attribute' => 'ID_BDT',
                'value' => 'baoduongtong.MA_BDT'
            ],
            [
                'attribute' => 'hinh_anh',
                'value' => function ($model) {
                    return Images::find()->where(['MA_DOTBD' => $model->MA_DOTBD])->count();
                }
            ],
            [
                'attribute' => 'cong_viec',
                'value' => function ($model) {
                    return Noidungcongviec::find()->where(['ID_DOTBD' => $model->ID_DOTBD])->andWhere(['<>', 'TRANGTHAI', 'NULL'])->count() ."/". Noidungcongviec::find()->where(['ID_DOTBD' => $model->ID_DOTBD])->count();
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    
                    'delete' => function ($url, $model) {
                        
                        if (Yii::$app->user->can('delete-dbd')) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['data-method' => 'post']);
                        } else {
                            return '';
                        }    
                    }

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = ['dotbaoduong/view', 'id' => $model->ID_DOTBD];
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = ['dotbaoduong/delete', 'id' => $model->ID_DOTBD];
                        return $url;
                    }
                }
            ],
        ],
    ]);
Pjax::end();
?>
</div>