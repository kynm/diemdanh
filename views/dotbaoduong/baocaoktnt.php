<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Baoduongtong;
use app\models\Images;
use app\models\Noidungcongviec;
use app\models\Daivt;
use app\models\Donvi;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Báo cáo kiểm tra nhà trạm';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ktnt-baocao">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => 'vnpt_mds/dotbaoduong/baocaoktnt'
        ]); ?>
        <div class="col-md-4 col-xs-8">
            <?= Select2::widget([
                'name' => 'ID_BDT',
                'id' => 'ID_BDT',
                'value' => '',
                'data' => ArrayHelper::map(Baoduongtong::find()->where(['type' => 0])->all(), 'ID_BDT', 'MA_BDT'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Chọn đợt kiểm tra nhà trạm...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]); ?>
        </div>
        <div class="col-md-4 col-xs-4">
            <?= Html::submitButton(
                '<i class="fa fa-search"></i> Xem báo cáo', 
                [
                    'class'=>'btn btn-primary btn-flat',
                    'id' => 'searchBtn',
                    
                ])
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <br>
    <?php if (isset($data)) { ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $bdt->MA_BDT .': '. $bdt->MO_TA ?></h3>
        </div>
        <div class="box-body">
            <div class="panel-body">
                <?php foreach ($data as $each) { ?>
                    <div class='col-md-3 col-sm-6'>
                        <div>
                            <?= ChartJs::widget([
                                'type' => 'doughnut',
                                'id' => 'structurePie'.$each['id'],
                                'options' => [
                                    'height' => 200
                                ],
                                'data' => [
                                    'radius' =>  "90%",
                                    'labels' => $each['labels'],
                                    'datasets' => [
                                        [
                                            'data' => $each['dataset'], // Your dataset
                                            'label' => '',
                                            'backgroundColor' => [
                                                'blue',
                                                'purple',
                                                '#DD4B39',
                                                '#F39C12',
                                                '#00A65A',
                                            ],
                                            'borderColor' =>  [
                                                    '#fff',
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
                                        // 'position' => 'bottom',
                                        // 'labels' => [
                                        //     'fontSize' => 14,
                                        //     'fontColor' => "#425062",
                                        // ]
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
                            ]);?>
                        </div>
                        <div class="chart-title"> <?= $each['name'] ?> </div>
                        <div class="chart-title"><?= $each['tyle'] ?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= 'Chi tiết '. $bdt->MO_TA ?></h3>
        </div>
            <div class="table-responsive">
                <?php 
                    Pjax::begin();
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        // 'rowOptions' => function ($model) {
                        //     if ($model->baocao->KETQUA == 'Chưa đạt') {
                        //         return ['class' => 'danger'];
                        //     }
                        // },
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'MA_DOTBD',
                            [
                                'attribute' => 'ID_TRAM',
                                'value' => 'tRAMVT.TEN_TRAM'
                            ],
                            [
                                'attribute' => 'ID_DAI',
                                'filter' => ArrayHelper::map(Daivt::find()->where(['<', 'ID_DAI', 16])->all(), 'ID_DAI', 'TEN_DAIVT'),
                                'value' => 'tRAMVT.iDDAI.TEN_DAIVT',
                            ],
                            [
                                'attribute' => 'ID_DONVI',
                                'value' => 'tRAMVT.iDDAI.iDDONVI.TEN_DONVI',
                                'filter' => ArrayHelper::map(Donvi::find()->where(['>', 'ID_DONVI', 3])->all(), 'ID_DONVI', 'TEN_DONVI'),
                            ],
                            [
                                'attribute' => 'ID_NHANVIEN',
                                'value' => 'nHANVIEN.TEN_NHANVIEN'
                            ],
                            [
                                'attribute' => 'TRANGTHAI',
                                'filter' => [
                                    "chuathuchien"=>"Chưa thực hiện",
                                    "chuahoanthanh"=>"Chưa hoàn thành",
                                    "ketthuc"=>"Kết thúc",
                                    "dangthuchien" => "Đang thực hiện",
                                    "kehoach" => "Kế hoạch"
                                ],
                                'value' => function($model) {
                                    switch ($model->TRANGTHAI) {
                                        case 'chuathuchien':
                                            return 'Chưa thực hiện';
                                        case 'chuahoanthanh':
                                            return 'Chưa hoàn thành';
                                        case 'ketthuc':
                                            return 'Kết thúc';
                                        case 'dangthuchien':
                                            return 'Đang thực hiện';
                                        case 'kehoach':
                                            return 'Kế hoạch';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'hinh_anh',
                                'value' => function ($model) {
                                    return Images::find()->where(['MA_DOTBD' => $model->MA_DOTBD])->count();
                                }
                            ],
                            [
                                'attribute' => 'cong_viec',
                                'value' => function ($model) {
                                    return Noidungcongviec::find()->where(['ID_DOTBD' => $model->ID_DOTBD])->andWhere(['<>', 'TRANGTHAI', 'NULL'])->count() ."/". Noidungcongviec::find()->where(['ID_DOTBD' => $model->ID_DOTBD])->count();
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                            ],
                        ],
                    ]);
                Pjax::end();
                ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>