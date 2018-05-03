<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Nhanvien;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KetquaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kết quả';
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['danhsachkehoach']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ketqua-index">
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'rowOptions' => function ($model) {
                        if ($model->baocao->KETQUA == 'Chưa đạt') {
                            return ['class' => 'danger'];
                        }
                    },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'MA_DOTBD',
                        [
                            'attribute' => 'NGAY_BD',
                            'format' => ['date', 'php:d/m/Y'],
                        ],
                        [
                            'attribute' => 'ID_TRAMVT',
                            'value' => 'tRAMVT.MA_TRAM'
                        ],
                        [
                            'attribute' => 'TRUONG_NHOM',
                            'value' => 'tRUONGNHOM.TEN_NHANVIEN'
                        ],
                        'TRANGTHAI',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {delete}',
                            'buttons' => [
                                
                                'delete' => function ($url, $model) {
                                    if ($model->TRUONG_NHOM == Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
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
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>