<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'QUẢN LÝ HỌC SINH';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đài viễn thông', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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