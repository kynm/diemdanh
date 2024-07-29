<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use app\models\Hocsinh;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'Quản lý điểm danh';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý điểm danh', 'url' => ['quanlydiemdanh/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quanlydiemdanh-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
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
                            [
                                'attribute' => 'THU',
                                'value'  => function($model) {
                                    return dateofmonth()[date_format(date_create($model->NGAY_DIEMDANH), 'w')];
                                },
                                'format' => 'raw',
                            ],
                            'NGAY_DIEMDANH',
                            'TIEUDE',
                            [
                                'attribute' => 'SOHOCSINH',
                                'value' =>function($model) {
                                    return $model->getDschitietdiemdanh()->count();
                                }
                            ],
                            [
                                'attribute' => 'SOHOCSINHDIHOC',
                                'value' =>function($model) {
                                    return $model->getDschitietdiemdanh()->andWhere(['STATUS' => 1])->count();
                                }
                            ],
                            [
                                'attribute' => 'VANG',
                                'value' =>function($model) {
                                    return '<span style="color: red; font-size:20px">' . $model->getDschitietdiemdanh()->andWhere(['STATUS' => 0])->count() . '</span>';
                                },
                                'format' => 'raw',
                            ],
                            [
                            'attribute' => 'DSHOCSINHVANG',
                            'value' =>function($model) {
                                $idhocsinh = ArrayHelper::map($model->getDschitietdiemdanh()->andWhere(['STATUS' => 0])->all(), 'ID_HOCSINH', 'ID_HOCSINH');
                                $dshocsinhvang = ArrayHelper::map(Hocsinh::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['in', 'ID', $idhocsinh])->all(), 'ID', 'HO_TEN');
                                return $dshocsinhvang ? implode(',', $dshocsinhvang) : null;
                            }
                        ],
                            
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
