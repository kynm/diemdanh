<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ThuchienbdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thực hiện bảo dưỡng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thuchienbd-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Thuchienbd', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID_DOTBD',
            'ID_THIETBI',
            'MA_NOIDUNG',
            'NOIDUNGMORONG',
            'KETQUA',
            // 'GHICHU',
            // 'ID_NHANVIEN',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
