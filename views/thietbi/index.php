<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ThietbiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loại thiết bị';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Thêm loại thiết bị', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'MA_THIETBI',
            'TEN_THIETBI',
            [
                'attribute' => 'ID_NHOMTB',
                'value' => 'iDNHOMTB.TEN_NHOM'
            ],
            'HANGSX',

            // 'THONGSOKT:ntext',
            // 'PHUKIEN:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
