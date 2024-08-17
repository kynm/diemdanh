<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhanvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý phụ huynh';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-index">
    <p>
        <?= (Yii::$app->user->can('quanlyphuhuynh')) ? Html::a('<i class="fa fa-plus"></i> Thêm phụ huynh', ['create'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'TEN_NHANVIEN',
                        'DIEN_THOAI',
                        [
                            'attribute' => 'CON',
                            'value' => function($model) {
                                return $model->getDshocsinh()->count();
                            }
                        ],
                        'USER_NAME',
                        ['class' => 'yii\grid\ActionColumn',
                        'template' => (Yii::$app->user->can('quanlyphuhuynh')) ? '{update}' : ''],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>