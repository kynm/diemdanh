<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $diemdanh->lop->MA_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đài viễn thông', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('_detail', ['model' => $diemdanh->lop,]) ?>
</div>
<?php if (Yii::$app->user->can('diemdanhlophoc')):?>
<div class="daivt-view">
    <?= $this->render('_form_diemdanh', ['model' => $diemdanh, 'id' => $diemdanh->ID_LOP,]) ?>
</div>
<?php endif; ?>
<div class="box box-primary">
    <div class="box-body">
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
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '/lophoc/capnhatdiemdanh?diemdanhid=' . $model->ID, [
                                    'title' => Yii::t('app', 'lead-update'),
                                ]);
                            },

                        ],
                    ],
                    'TIEUDE',
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
                    
                ],
            ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
