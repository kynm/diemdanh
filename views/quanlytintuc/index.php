<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhanvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QUẢN LÝ TIN TỨC';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-index">
    <p>
        <?= (Yii::$app->user->can('quanlytintuc')) ? Html::a('<i class="fa fa-plus"></i> Thêm tin tức', ['create'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    // 'formatter' => [
                    //     'class' => 'yii\i18n\Formatter',
                    //     'nullDisplay' => '',
                    // ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        // 'MA_NHANVIEN',
                        'TITLE',
                        // [
                        //     'attribute' => 'ID_DONVI',
                        //     'value' => 'iDDONVI.TEN_DONVI'
                        // ],
                        ['class' => 'yii\grid\ActionColumn',
                        'template' => (Yii::$app->user->can('edit-nhanvien')) ? '{view} {update}' : '{view}'],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>