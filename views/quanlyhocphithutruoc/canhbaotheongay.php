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
    <p>
        <?= Html::a('<i class="fa fa-print"></i> Print', ['quanlyhocphithutruoc/canhbaotheongayprint', 'HocsinhSearch[ID_LOP]' => $params['HocsinhSearch']['ID_LOP']], [
            'class' => 'btn btn-primary btn-flat pull-right', 'id' => 'canhbaotheongayprint', 'target' => '_blank']) ?>
    </p>
    <div class="box-body">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function ($model, $index, $widget, $grid){
                      return ['style'=>'color:'. colorsthuhocphitheongay($model->NGAY_KT) .' !important;'];
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
                        'attribute' => 'NGAY_BD',
                        'value' => function($model) {
                            $last = $model->getDshocphithutruoc()->andWhere(['STATUS' => 2])->orderBy(['NGAY_KT' => SORT_DESC])->limit(1)->one();
                            return isset($last->NGAY_BD) ? Yii::$app->formatter->asDatetime($last->NGAY_BD, 'php:d/m/Y') : NULL;
                        },
                    ],
                    [
                        'attribute' => 'NGAY_KT',
                        'value' => function($model) {
                            return $model->NGAY_KT ? Yii::$app->formatter->asDatetime($model->NGAY_KT, 'php:d/m/Y') : NULL;
                        },
                    ],
                    [
                        'attribute' => 'SOBH_DAMUA',
                        'contentOptions' => ['style' => 'width:7%; white-space: normal;word-break: break-word;'],
                        'value' => function ($model) {
                            $sobuoi = in_array($model->HT_HP, [2,3]) ? $model->getDshocphithutruoc()->andWhere(['STATUS' => 2])->sum('SO_BH') : null;
                            return $sobuoi;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'SOBH_DAHOC',
                        'contentOptions' => ['style' => 'width:7%; white-space: normal;word-break: break-word;'],
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
<?php
$script = <<< JS
    $(document).on('change', '#hocsinhsearch-id_lop', function() {
        var idlop = $(this).val();
        $('#canhbaotheongayprint').attr("href", "/quanlyhocphithutruoc/canhbaotheongayprint?HocsinhSearch[ID_LOP]=" + idlop);
    });
JS;
$this->registerJs($script);
?>