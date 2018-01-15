<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Thuchienbd;
use app\models\ThuchienbdSearch;
use app\models\Dotbaoduong;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Ketqua */

$this->title = 'Đợt '.$model->iDDOTBD->MA_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['danhsachkehoach']];
$this->params['breadcrumbs'][] = ['label' => 'Kết quả', 'url' => ['danhsachketqua']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ketqua-view">

    

    <div class="ketqua-form">
        
        <p class="form-inline">
            <div class="col-md-12 form-group">                
                <?php
                    Modal::begin([
                    'toggleButton' => [
                        'label' => '<i class="glyphicon glyphicon-list"></i> Chi tiết',
                        'class' => 'btn btn-primary'
                    ],
                        'size' => 'modal-lg',
                    ]);
                        $searchModel = new ThuchienbdSearch();
                        $dataProvider = $searchModel->searchND(Yii::$app->request->queryParams);

                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'formatter' => [
                            'class' => 'yii\i18n\Formatter',
                            'nullDisplay' => '',
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [ 
                                'attribute' => 'ID_THIETBI',
                                'value' => 'iDTHIETBI.iDLOAITB.TEN_THIETBI'
                            ],
                            [ 
                                'attribute' => 'MA_NOIDUNG',
                                'value' => 'mANOIDUNG.NOIDUNG'
                            ],
                            'NOIDUNGMORONG',
                            [
                                'attribute' => 'ID_NHANVIEN',
                                'value' => 'iDNHANVIEN.TEN_NHANVIEN'
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
                <input type="text" class="form-control" disabled="true" value="<?= $model->iDDOTBD->iDTRAMVT->MA_TRAM ; ?>">
            </div>
            <div class="form-group col-md-3 col-sm-6">
                <label>Ngày bảo dưỡng</label>
                <input type="text" class="form-control" disabled="true" value="<?= $model->iDDOTBD->NGAY_BD ; ?>">
            </div>
            <div class="form-group col-md-3 col-sm-6">
                <label>Nhóm trưởng</label>
                <input type="text" class="form-control" disabled="true" value="<?= $model->iDDOTBD->tRUONGNHOM->TEN_NHANVIEN ; ?>">
            </div>
            <div class="form-group col-md-3 col-sm-6">
                <label>Trạng thái</label>
                <input type="text" class="form-control" disabled="true" value="<?= $model->iDDOTBD->TRANGTHAI ; ?>">
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
                <a href="<?= $model->ANH1 ?>" class="thumbnail">
                    <img src="<?= $model->ANH1 ?>" alt="Anh 1">
                </a>
            </div>
            <?= isset($model->ANH2) ? '
            <div class="col-md-4 col-sm-4 col-xs-12">
                <a href="'. $model->ANH2 .'" class="thumbnail">
                  <img src="'. $model->ANH2 .'" alt="Anh 2">
                </a>
            </div>' : ''
            ?>
            <?= isset($model->ANH3) ? '
            <div class="col-md-4 col-sm-4 col-xs-12">
                <a href="'. $model->ANH3 .'" class="thumbnail">
                  <img src="'. $model->ANH3 .'" alt="Anh 3">
                </a>
            </div>' : ''
            ?>
        </div>
        </p>
    
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