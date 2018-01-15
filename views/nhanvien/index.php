<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhanvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhân viên';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-index">

    <p>
        <?= Html::a('Thêm nhân viên', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'MA_NHANVIEN',
                'TEN_NHANVIEN',
                'CHUC_VU',
                'DIEN_THOAI',
                [
                    'attribute' => 'ID_DONVI',
                    'value' => 'iDDONVI.TEN_DONVI'
                ],
                [
                    'attribute' => 'ID_DAI',
                    'value' => 'iDDAI.TEN_DAIVT'
                ],
                
                'USER_NAME',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
