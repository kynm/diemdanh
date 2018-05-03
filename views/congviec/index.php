<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ThuchienbdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Công việc';;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thuchienbd-congviec">
<div class="box box-primary">
    <div class="box-body">
    <?php
        $items = [
            [
                'label'=>'<i class="fa fa-cogs"></i> Đang thực hiện',
                'content'=>$this->render('_tab_inProgress', [
                    'searchModel' => $searchModel,
                    'inprogressProvider' => $inprogressProvider 
                ]),
                'active'=>true
            ],
            [
                'label'=>'<i class="fa fa-bar-chart"></i> Trong kế hoạch',
                'content'=>$this->render('_tab_plan', [
                    'searchModel' => $searchModel,
                    'planProvider' => $planProvider 
                ]),
            ],
            [
                'label'=>'<i class="fa fa-pie-chart"></i> Hoàn thành',
                'content'=>$this->render('_tab_finished', [
                    'searchModel' => $searchModel,
                    'finishedProvider' => $finishedProvider 
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
</div>
</div>

