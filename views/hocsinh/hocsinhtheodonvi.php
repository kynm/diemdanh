<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'QUẢN LÝ HỌC SINH';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'ID_LOP',
                        'value' => 'lop.TEN_LOP',
                        'contentOptions' => ['style' => 'width:20%; white-space: normal;'],
                        'filter'=> $dslop,
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'options' => ['prompt' => ''],
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ],
                    'MA_HOCSINH',
                    'HO_TEN',
                    'DIA_CHI',
                    'SO_DT',
                    'NGAY_BD',
                    'NGAY_KT',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => (Yii::$app->user->can('edit-hocsinh')) ? '{view} {update}' : '{view}'
                    ],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>