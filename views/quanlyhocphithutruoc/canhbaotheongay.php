<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'HỌC SINH THEO NGÀY HẾT HẠN';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <?= $this->render('/partial/_header_hocphithutruoc', []) ?>
    <div class="box-body">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function ($model, $index, $widget, $grid){
                      return $model->NGAY_KT ?  ['style'=>'color:'. colorsthuhocphitheongay($model->NGAY_KT) .' !important;'] : [];
                    },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'ID_LOP',
                        'value' => 'lop.TEN_LOP',
                        'contentOptions' => ['style' => 'width:20%;white-space: normal;word-break: break-word;word-break: break-word'],
                        'filter'=> $dslop,
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'options' => ['prompt' => ''],
                            'pluginOptions' => ['allowClear' => true],
                        ],
                    ],
                    [
                        'attribute' => 'HO_TEN',
                        'value' => function ($model) {
                            return Yii::$app->user->can('quanlyhocsinh') && Yii::$app->user->identity->nhanvien->ID_DONVI == $model->ID_DONVI ? Html::a($model->HO_TEN, ['/hocsinh/lichsudiemdanh', 'id' => $model->ID], ['class' => 'text text-primary']) : '';
                        },
                        'format' => 'raw',
                    ],
                    'SO_DT',
                    [
                        'attribute' => 'NGAY_KT',
                        'value' => function($model) {
                            return $model->NGAY_KT ? Yii::$app->formatter->asDatetime($model->NGAY_KT, 'php:d/m/Y') : NULL;
                        },
                    ],
                    'TIENHOC',
                    [
                        'attribute' => 'SOBH_DAHOC',
                        'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                        'value' => function ($model) {
                            return $model->getDsdiemdanh()->andWhere(['STATUS' => 1])->count();
                        },
                        'format' => 'raw',
                    ],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>