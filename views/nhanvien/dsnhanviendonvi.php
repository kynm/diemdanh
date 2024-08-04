<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhanvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'DANH SÁCH NHÂN VIÊN ĐƠN VỊ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-index">
    <p>
        <?= (Yii::$app->user->can('quanlytruonghoc')) ? Html::a('<i class="fa fa-plus"></i> Thêm nhân viên', ['taomoinhanviendonvi'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
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
                        'USER_NAME',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>