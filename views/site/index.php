<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dosamigos\chartjs\ChartJs;
use app\models\ActivitiesLog;
use app\models\Baoduongtong;
use app\models\Daivt;
use app\models\Donvi;
use app\models\Dotbaoduong;
use app\models\Images;
use app\models\Nhomtbi;
use app\models\Noidungcongviec;
use app\models\Tramvt;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
?>
<div class="index">
    <div class="row">
        <div class="col-lg-7">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Hoạt động gần đây</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        <?php $activities = ActivitiesLog::find()->orderBy(['activity_log_id' => SORT_DESC])->limit(5)->all(); 
                        foreach ($activities as $activity) {
                            echo '<li class="item">
                                <div class="product-img">
                                    <img src="'. Yii::getAlias('@web').'/'.$activity->user->avatar .'" class="img-circle" alt="Avatar Image">
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title"><i class="'. $activity->activityType->class .'"></i> '. $activity->activityType->activity_name .'
                                        <span class="label label-info pull-right">'.date("d/m/y H:i:s", $activity->create_at) .'</span></a>
                                    <span class="product-description">
                                        '. $activity->description .'
                                    </span>
                                </div>
                          </li>';
                        }
                        ?>
                        <!-- /.item -->
                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="<?= Url::to(['activities-log/index']) ?>" class="uppercase">Xem tất cả</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-lg-5">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tài liệu hướng dẫn và phần mềm</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul>
                        <li>Phiên bản website
                            <ul>
                                <iframe src="https://www.youtube.com/embed/bUiQB9LHBC4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            
                            </ul>
                        </li>
                        <li>Phiên bản mobile
                            <ul>
                                <li>
                                    <a href="https://tinyurl.com/mdsmobile-huongdan" class="uppercase">Hướng dẫn cài đặt và sử dụng</a>
                                </li>
                                <li>
                                    <a href="https://tinyurl.com/mdsmobile-caidat" class="uppercase">File cài đặt</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <?php if (isset($data)) { ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $bdt->MA_BDT .': '. $bdt->MO_TA ?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
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
                                'urlCreator' =>function ($action, $model, $key, $index) {
                                    if ($action === 'view') {
                                        $url = ['dotbaoduong/view', 'id' => $model->ID_DOTBD];
                                        return $url;
                                    }
                                }
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