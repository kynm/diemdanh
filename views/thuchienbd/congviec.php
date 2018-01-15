<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ThuchienbdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Công việc';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thuchienbd-congviec">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'ID_THIETBI',
                'value' => 'iDTHIETBI.iDLOAITB.TEN_THIETBI'
            ],
            [
                'attribute' => 'MA_NOIDUNG',
                'value' => 'mANOIDUNG.NOIDUNG'
            ],
            [
                'attribute' => 'ID_DOTBD',
                'value' => 'iDDOTBD.MA_DOTBD',
            ],
            [
                'attribute' => 'Trạng thái',
                'value' => 'iDDOTBD.TRANGTHAI'
            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>

