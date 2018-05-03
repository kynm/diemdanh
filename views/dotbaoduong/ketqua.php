<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Noidungcongviec;
use app\models\NoidungcongviecSearch;
use app\models\Dotbaoduong;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Ketqua */

$this->title = 'Đợt '.$model->dOTBD->MA_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['danhsachkehoach']];
$this->params['breadcrumbs'][] = ['label' => 'Kết quả', 'url' => ['danhsachketqua']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ketqua-view">
    <div class="box box-primary">
        <div class="box-body">
            <p class="form-inline">
                <div class="col-md-12 form-group">                
                    <?php
                        Modal::begin([
                        'toggleButton' => [
                            'label' => '<i class="glyphicon glyphicon-list"></i> Chi tiết',
                            'class' => 'btn btn-primary btn-flat'
                        ],
                            'size' => 'modal-lg',
                        ]);
                            $searchModel = new NoidungcongviecSearch();
                            $dataProvider = $searchModel->searchDbd($model->ID_DOTBD);

                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'formatter' => [
                                'class' => 'yii\i18n\Formatter',
                                'nullDisplay' => '',
                            ],
                            'rowOptions' => function ($model) {
                                if ($model->KETQUA == 'Chưa đạt') {
                                    return ['class' => 'danger'];
                                }
                            },
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [ 
                                    'attribute' => 'ID_THIETBI',
                                    'value' => 'tHIETBI.iDLOAITB.TEN_THIETBI'
                                ],
                                [ 
                                    'attribute' => 'MA_NOIDUNG',
                                    'value' => 'mANOIDUNG.NOIDUNG'
                                ],
                                [
                                    'attribute' => 'ID_NHANVIEN',
                                    'value' => 'nHANVIEN.TEN_NHANVIEN'
                                ],
                                [ 
                                    'attribute' => 'KETQUA',
                                    'value' => 'KETQUA',
                                ],
                                'GHICHU',
                            ],
                        ]);
                        Modal::end(); 
                    ?>
                </div>
                
                <div class="form-group col-md-3 col-sm-6">
                    <label>Trạm viễn thông</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->dOTBD->tRAMVT->MA_TRAM ; ?>">
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Ngày bảo dưỡng</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->dOTBD->NGAY_BD ; ?>">
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Nhóm trưởng</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->dOTBD->tRUONGNHOM->TEN_NHANVIEN ; ?>">
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label>Trạng thái</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->dOTBD->TRANGTHAI ; ?>">
                </div>
                <div class="form-group col-md-12">
                    <label>Kết quả</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->KETQUA ; ?>">
                </div>
                <div class="form-group col-md-12">
                    <label>Ghi chú</label>
                    <input type="text" class="form-control" disabled="true" value="<?= $model->GHICHU ; ?>">
                </div>
        
            <div class="row col-md-12">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <a href="<?= Yii::$app->homeUrl .'/'. $model->ANH1 ?>" class="thumbnail">
                        <img src="<?= Yii::$app->homeUrl .'/'. $model->ANH1 ?>" alt="Anh 1">
                    </a>
                </div>
                <?= isset($model->ANH2) ? '
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <a href="'. Yii::$app->homeUrl .'/'. $model->ANH2 .'" class="thumbnail">
                      <img src="'. Yii::$app->homeUrl .'/'. $model->ANH2 .'" alt="Anh 2">
                    </a>
                </div>' : ''
                ?>
                <?= isset($model->ANH3) ? '
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <a href="'. Yii::$app->homeUrl .'/'. $model->ANH3 .'" class="thumbnail">
                      <img src="'. Yii::$app->homeUrl .'/'. $model->ANH3 .'" alt="Anh 3">
                    </a>
                </div>' : ''
                ?>
            </div>
            </p>
        </div>
    </div>        
</div>
            



<?php
$script = <<< JS
    $('.row').magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery:{
            enabled:true
        },
        removalDelay: 300,
        mainClass: 'mfp-with-zoom', 

        zoom: {
            enabled: true, 

            duration: 300, 
            easing: 'ease-in-out', 
            opener: function(openerElement) {
              return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });
JS;
$this->registerJs($script);
?>