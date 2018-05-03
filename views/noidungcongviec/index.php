<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoidungcongviecSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Công việc';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noidungcongviec-index">
    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Thêm nội dung', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'ID_DOTBD',
                    'ID_THIETBI',
                    'MA_NOIDUNG',
                    'GHICHU:ntext',
                    'TRANGTHAI',
                    'ID_NHANVIEN',
                    'KETQUA',

                    ['class' => 'yii\grid\ActionColumn',
                    'template' => (Yii::$app->user->can('edit-noidungcongviec')) ? '{view} {update} {delete}' : '{view}'],
                ],
            ]); ?>
        </div>
    </div>
</div>