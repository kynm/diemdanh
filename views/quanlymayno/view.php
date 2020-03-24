<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use app\models\Thietbitram;
use app\models\Thietbi;
use app\models\Tramvt;
use app\models\Dotbaoduong;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */

$this->title = 'Trạm '.$model->TEN_TRAM;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị theo trạm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$visible = false;
if (Yii::$app->user->can('edit-tramvt')) {
    switch (Yii::$app->user->identity->nhanvien->chucvu->cap) {
        case '1':
            $visible = true;
            break;
        case '2':
            if ($model->iDDAI->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $visible = true;
            }
            break;
        case '3':
            if ($model->ID_DAI == Yii::$app->user->identity->nhanvien->ID_DAI) {
                $visible = true;
            }
            break;
        case '4':
            if ($model->ID_NHANVIEN == Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
                $visible = true;
            }
            break;
        case '5':
            if ($model->ID_DAI == Yii::$app->user->identity->nhanvien->ID_DAI) {
                $visible = true;
            }
            break;
        
        default:
            $visible = false;
            break;
    }
}

?>
<div class="tramvt-view">

    <div class="box box-primary">
        <div class="box-body">
            <br>

            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => '{items}{pager}',
                    'columns' => [
                        ['class' => 'yii\grid\CheckboxColumn', 'visible' => $visible],
                        ['class' => 'yii\grid\SerialColumn', 'visible' => !$visible],

                        [
                            'attribute' => 'ID_LOAITB',
                            'value' => 'iDLOAITB.TEN_THIETBI'
                        ],
                        [
                            'attribute' => 'ID_TRAM',
                            'value' => 'iDTRAM.TEN_TRAM'
                        ],
                        'LANBAODUONGTRUOC',
                        'LANBAODUONGTIEP',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}',
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'update') {
                                    $url = Url::to(['quanlymayno/update', 'id' => $model->ID_THIETBI]);
                                    return $url;
                                }
                            }
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
