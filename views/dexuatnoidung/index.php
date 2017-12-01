<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DexuatnoidungSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đề xuất nội dung';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dexuatnoidung-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Thêm đề xuất', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'ID_LOAITB',
                'value' => 'iDLOAITB.TEN_THIETBI'
            ],
            'LAN_BD',
            'CHUKYBAODUONG',
            'MA_NOIDUNG',
            // [
            //     'attribute' => 'MA_NOIDUNG',
            //     'value' => 'mANOIDUNG.NOIDUNG'
            // ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
