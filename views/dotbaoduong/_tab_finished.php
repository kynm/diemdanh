<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Baoduongtong;
use app\models\Images;
use app\models\Noidungcongviec;
use app\models\Daivt;
?>
<div class="table-responsive">
<?php
Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $finishedProvider,
        'filterModel' => $searchModel,
        // 'rowOptions' => function ($model) {
        //     if ($model->baocao->KETQUA == 'Chưa đạt') {
        //         return ['class' => 'danger'];
        //     }
        // },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'MA_DOTBD',
            [
                'attribute' => 'ID_TRAM',
                'value' => 'tRAMVT.TEN_TRAM'
            ],
            [
                'attribute' => 'ID_DAI',
                'filter' => ArrayHelper::map(Daivt::find()->where(['<', 'ID_DAI', 16])->all(), 'ID_DAI', 'TEN_DAIVT'),
                'value' => 'tRAMVT.iDDAI.TEN_DAIVT',
            ],
            // [
            //     'attribute' => 'NGAY_BD',
            //     'format' => ['date', 'php:d/m/Y'],
            // ],
            [
                'attribute' => 'NGAY_KT',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'ID_NHANVIEN',
                'value' => 'nHANVIEN.TEN_NHANVIEN'
            ],
            [
                'attribute' => 'ID_BDT',
                'value' => 'baoduongtong.MA_BDT',
                'filter'=>ArrayHelper::map(Baoduongtong::find()->asArray()->all(), 'MA_BDT', 'MA_BDT'),
            ],
            [
                'attribute' => 'TRANGTHAI',
                'filter' => [
                    "chuathuchien"=>"Chưa thực hiện",
                    "chuahoanthanh"=>"Chưa hoàn thành",
                    "ketthuc"=>"Kết thúc"
                ],
                'value' => function($model) {
                    switch ($model->TRANGTHAI) {
                        case 'chuathuchien':
                            return 'Chưa thực hiện';
                        case 'chuahoanthanh':
                            return 'Chưa hoàn thành';
                        case 'ketthuc':
                            return 'Kết thúc';
                    }
                }
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
                'template' => '{view} {re-do} {delete}',
                'buttons' => [
                    're-do' => function ($url, $model) {
                        if (Yii::$app->user->can('Administrator')) {
                            return Html::a('<span class="glyphicon glyphicon-transfer"></span>', $url, ['data-method' => 'post']);
                        } else {
                            return '';
                        } 
                    },
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
                    if ($action === 're-do') {
                        $url = ['dotbaoduong/thuchien', 'id' => $model->ID_DOTBD];
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