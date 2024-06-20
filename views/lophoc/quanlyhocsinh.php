<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $model->MA_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đài viễn thông', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('_detail', ['model' => $model,]) ?>
</div>
<?php if (Yii::$app->user->can('quanlyhocsinh')):?>
<div class="daivt-view">
    <?= $this->render('_form_hocsinh', ['model' => $hocsinh, 'id' => $model->ID_LOP]) ?>
</div>
<?php endif; ?>
<div class="box box-primary">
    <div class="box-body">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'MA_HOCSINH',
                    'HO_TEN',
                    'DIA_CHI',
                    'SO_DT',
                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'template' => (Yii::$app->user->can('edit-lophoc')) ? '{view} {update} {delete}' : '{view}'
                    // ],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>