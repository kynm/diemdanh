<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ThuchienbdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thực hiện';
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['danhsachkehoach']];
$this->params['breadcrumbs'][] = $this->title;
// print_r($this->params['breadcrumbs']);
// die;
?>
<div class="thuchienbd-index">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'MA_DOTBD',
            'NGAY_BD',
            [
                'attribute' => 'ID_TRAMVT',
                'value' => 'iDTRAMVT.MA_TRAM'
            ],
            [
                'attribute' => 'TRUONG_NHOM',
                'value' => 'tRUONGNHOM.TEN_NHANVIEN'
            ],
            'TRANGTHAI',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = '';
                        $url ='index.php?r=dotbaoduong/thuchien&id='.$model->ID_DOTBD;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = '';
                        $url ='index.php?r=dotbaoduong/delete&id='.$model->ID_DOTBD;
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

