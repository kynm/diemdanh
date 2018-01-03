<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhomtbiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhóm thiết bị';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhomtbi-index">

    <p>
        <?= Html::a('Thêm nhóm thiết bị mới', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'MA_NHOM',
            'TEN_NHOM',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
