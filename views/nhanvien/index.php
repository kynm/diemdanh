<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhanvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhân viên';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-index">
    <p>
        <?= (Yii::$app->user->can('Administrator')) ? Html::a('<i class="fa fa-plus"></i> Thêm nhân viên', ['create'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
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
                        'TEN_NHANVIEN',
                        [
                            'attribute' => 'CHUC_VU',
                            'value' => 'chucvu.ten_chucvu'
                        ],
                        'DIEN_THOAI',
                        [
                            'attribute' => 'ID_DONVI',
                            'value' => 'iDDONVI.TEN_DONVI'
                        ],
                        'USER_NAME',
                        ['class' => 'yii\grid\ActionColumn',
                        'template' => (Yii::$app->user->can('edit-nhanvien')) ? '{view} {update} {delete}' : '{view}'],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>