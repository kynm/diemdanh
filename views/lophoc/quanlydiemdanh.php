<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Hocsinh;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $diemdanh->lop->MA_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('_detail', ['model' => $diemdanh->lop,]) ?>
</div>
<?php if (Yii::$app->user->can('diemdanhlophoc')):?>
    <div class="daivt-view">
        <?= $this->render('_form_diemdanh', ['model' => $diemdanh, 'id' => $diemdanh->ID_LOP,]) ?>
    </div>
    <h1 class="text-center text-danger">LỚP HỌC ĐÃ ĐIỂM ĐANH TRONG NGÀY!</h1>
<?php endif; ?>
<div class="box box-primary">
    <div class="box-body">
        <div class="table-responsive">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => (Yii::$app->user->can('diemdanhlophoc')) ? '{updatediemdanh}' : '',
                            'buttons' => [
                                'updatediemdanh' => function ($url, $model) {
                                    return Html::a($model->TIEUDE, '/lophoc/capnhatdiemdanh?diemdanhid=' . $model->ID);
                                },
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
                            'attribute' => 'DSHOCSINHVANG',
                            'value' =>function($model) {
                                $idhocsinh = ArrayHelper::map($model->getDschitietdiemdanh()->andWhere(['STATUS' => 0])->all(), 'ID_HOCSINH', 'ID_HOCSINH');
                                $dshocsinhvang = ArrayHelper::map(Hocsinh::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['in', 'ID', $idhocsinh])->all(), 'ID', 'HO_TEN');
                                return implode(',', $dshocsinhvang);
                            }
                        ],
                        [
                            'attribute' => 'GHICHU',
                            'value' =>function($model) {
                                return $model->ghichu;
                            },
                            'format' => 'raw',
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
