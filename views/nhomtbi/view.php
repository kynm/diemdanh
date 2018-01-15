<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Nhomtbi */

$this->title = $model->TEN_NHOM;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhomtbi-view">

    <p>
        <?= Html::a('Thêm loại thiết bị', ['thietbi/create', 'id' => $model->ID_NHOM], ['class' => 'btn btn-primary']) ?>
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

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url ='index.php?r=thietbi/view&id='.$model->ID_THIETBI;
                        return $url;
                    }
                    if ($action === 'update') {
                        $url ='index.php?r=thietbi/update&id='.$model->ID_THIETBI;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url ='index.php?r=thietbi/delete&ID_DOTBD='.$model->ID_THIETBI;
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>

</div>
