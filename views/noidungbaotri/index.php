<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NoidungbaotriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nội dung bảo dưỡng';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noidungbaotri-index">
    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Thêm nội dung', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'MA_NOIDUNG',
                        ['attribute' => 'ID_THIETBI', 'value' => 'iDTHIETBI.TEN_THIETBI'],
                        'NOIDUNG',

                        ['class' => 'yii\grid\ActionColumn',
                        'template' => (Yii::$app->user->can('edit-noidungbaotri')) ? '{view} {update} {delete}' : '{view}'],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
