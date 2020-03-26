<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Daivt;
use app\models\Nhanvien;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
$this->title = 'Nhật ký sử dụng máy nổ ' . $thietbitram->iDLOAITB->TEN_THIETBI . ' Tại trạm ' . $thietbitram->iDTRAM->TEN_TRAM . $thietbitram->ID_TRAM;
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="tramvt-update">
    <?= $this->render('_form', [
        'model' => $model,
        'thietbitram' => $thietbitram,
    ]) ?>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'ID_THIETBITRAM',
                            'value' => 'ID_THIETBITRAM'
                        ],
                        [
                            'attribute' => 'ID_NV_VANHANH',
                            'value' => 'nHANVIENVANHANH.TEN_NHANVIEN'
                        ],
                        'DINHMUC',
                        [
                            'attribute' => 'GIATIEN',
                            'value' => 'GIATIEN'
                        ],
                        [
                            'attribute' => 'THOIGIANBATDAU',
                            // 'format' => ['date', 'php:d/m/Y H:i'],
                        ],
                        [
                            'attribute' => 'THOIGIANKETTHUC',
                            // 'format' => ['date', 'php:d/m/Y H:i'],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action ==  'update') {
                                    $url = Url::to(['quanlymayno/updatenhatky', 'id' => $model->ID]);
                                    return $url;
                                }
                                if ($action ==  'delete') {
                                    $url = Url::to(['quanlymayno/deletenhatky', 'id' => $model->ID]);
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