<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Các đợt kiểm tra nhà trạm';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ktnt-index">

            <?php
                $items = [
                    [
                        'label'=>'<i class="fa fa-bar-chart"></i> Trong kế hoạch',
                        'content'=>$this->render('_tab_plan', [
                            'searchModel' => $searchModel,
                            'planProvider' => $planProvider 
                        ]),
                        'active'=>true
                    ],
                    [
                        'label'=>'<i class="fa fa-cogs"></i> Đang thực hiện',
                        'content'=>$this->render('_tab_inProgress', [
                            'searchModel' => $searchModel,
                            'inprogressProvider' => $inprogressProvider 
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