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
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">
                    <ul>
                        <li>
                            <a href="https://drive.google.com/file/d/1akPjH6DncfJe2odo7LUeWOEmHQOGQpgO/view?usp=sharing" target="_blank">Hướng dẫn sử dụng phần mềm</a>
                        </li>
                        <li>
                            <a href="https://docs.google.com/spreadsheets/d/1N1R92fV6yufSyAaJzPiUN2qFQfyOv0W5QeFUfnv4dr4/edit?usp=sharing" target="_blank">Góp ý và báo lỗi</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    
</div>
