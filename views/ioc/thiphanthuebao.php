<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;
use kartik\select2\Select2;
use dosamigos\chartjs\ChartJs;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="row">
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Tên đơn vị</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thị phần</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        $labels = [];
                        $data = [];
                        // $backgroundColor = [];
                             foreach ($thiphan as $key => $value): 
                                $labels[] = $value['NHAMANG'];
                                $data[] = $value['SO_LUONG'];
                                ?>
                            <tr>
                                <td><?php echo $value['NHAMANG']?></td>
                                <td><?php echo $value['SO_LUONG']?></td>
                                <td><?php echo formatnumber($value['SO_LUONG'] * 100 / $tongthuebao, 2)?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" style="text-align: center;"><h2>Biểu đồ thể hiện thị phần của các nhà mạng<h2></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <?php 
                                    echo ChartJs::widget([
                                        'type' => 'pie',
                                        'id' => 'structurePie',
                                        'options' => [
                                            'height' => 400,
                                            'width' => 600,
                                        ],
                                        'data' => [
                                            'radius' =>  "90%",
                                            'labels' => $labels, // Your labels
                                            'datasets' => [
                                                [
                                                    'data' => $data, // Your dataset
                                                    'label' => '',
                                                    'backgroundColor' => [
                                                            'rgba(190, 124, 145, 0.8)',
                                                            '#ADC3FF',
                                                            '#FF9A9A',
                                                        'yellow'
                                                    ],
                                                    'borderColor' =>  [
                                                            '#fff',
                                                            '#fff',
                                                            '#fff',
                                                            '#fff'
                                                    ],
                                                    'borderWidth' => 1,
                                                    'hoverBorderColor'=>["#999","#999","#999"],                
                                                ]
                                            ]
                                        ],
                                        'clientOptions' => [
                                            'legend' => [
                                                'display' => false,
                                                'position' => 'bottom',
                                                'labels' => [
                                                    'fontSize' => 14,
                                                    'fontColor' => "#425062",
                                                ]
                                            ],
                                            'tooltips' => [
                                                'enabled' => true,
                                                'intersect' => true
                                            ],
                                            'hover' => [
                                                'mode' => false
                                            ],
                                            'maintainAspectRatio' => false,

                                        ],
                                    ])
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

