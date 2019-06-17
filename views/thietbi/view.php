<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */

$this->title = $model->TEN_THIETBI;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => $model->iDNHOM->TEN_NHOM, 'url' => ['nhomtbi/view', 'id' => $model->ID_NHOM]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbi-view">
    <?php
        $items = [
            [
                'label'=>'<i class="fa fa-info-circle"></i> Thông tin',
                'content'=>$this->render('_tab_thongtin', [
                    'model' => $model,
                    'dataProvider' => $dataProvider 
                ]),
                'active'=>true
            ],
            [
                'label'=>'<i class="fa fa-map-marker"></i> Danh sách nhà trạm',
                'content'=>$this->render('_tab_tram', [
                    'tramDataProvider' => $tramDataProvider 
                ]),
            ],
        ];

        echo TabsX::widget([
            'position'=>TabsX::POS_ABOVE,
            'containerOptions' => [
                'class' => 'nav-tabs-custom',
            ],
            'items'=>$items,
            'encodeLabels'=>false
        ]);
    ?>
</div>
