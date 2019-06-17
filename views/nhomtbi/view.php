<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use app\models\Nhomtbi;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->TEN_NHOM;
$this->params['breadcrumbs'][] = ['label' => 'Nhóm thiết bị', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhomtbi-view">
            <?php
                
                $items = [
                    [
                        'label'=>'<i class="fa fa-bar-chart"></i> Danh sách thiết bị',
                        'content'=>$this->render('_tab_devices', [
                            'devicesSearchModel' => $devicesSearchModel,
                            'devicesProvider' => $devicesProvider ,
                            'model' => $model,
                        ]),
                        'active'=>true
                    ],
                    [
                        'label'=>'<i class="fa fa-cogs"></i> Nội dung bảo dưỡng',
                        'content'=>$this->render('_tab_contents', [
                            // 'contentSearchModel' => $contentSearchModel,
                            'contentsProvider' => $contentsProvider 
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