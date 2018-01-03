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

    <p>
        <?= Html::a('Thêm đề xuất', ['create'], ['class' => 'btn btn-primary']) ?>
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
