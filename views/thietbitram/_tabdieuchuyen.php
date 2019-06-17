<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Tramvt;
use app\models\Nhomtbi;
use app\models\Dieuchuyenthietbi;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

Pjax::begin();
echo GridView::widget([
    'dataProvider' => $dieuchuyenProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'ID_TRAM_NGUON',
            'value' => 'iDTRAMNGUON.TEN_TRAM'
        ],
        [
            'attribute' => 'ID_TRAM_DICH',
            'value' => 'iDTRAMDICH.TEN_TRAM'
        ],
        'NGAY_CHUYEN',
        [
            'attribute' => 'LY_DO',
            'format' => 'raw'
        ],

        // ['class' => 'yii\grid\ActionColumn',
        // 'template' => (Yii::$app->user->can('edit-nhomtb')) ? '{view} {update} {delete}' : '{view}'],
    ],
]);
Pjax::end(); 
?>
