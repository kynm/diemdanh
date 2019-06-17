<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Dotbaoduong;
use app\models\Noidungbaotri;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Thietbi;

?>
	<div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-body">
                    <p class="form-inline">
                        <div class="form-group col-md-3">
                            <label>Mã thiết bị</label>
                            <input type="text" class="form-control" disabled="true" value="<?= $model->MA_THIETBI ; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tên thiết bị</label>
                            <input type="text" class="form-control" disabled="true" value="<?= $model->TEN_THIETBI ; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Nhóm thiết bị</label>
                            <input type="text" class="form-control" disabled="true" value="<?= $model->iDNHOM->TEN_NHOM ; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Hãng sản xuất</label>
                            <input type="text" class="form-control" disabled="true" value="<?= $model->HANGSX ; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Thông số kỹ thuật</label>
                            <textarea class="form-control" disabled="true" rows="4"><?= $model->THONGSOKT ; ?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phụ kiện</label>
                            <textarea class="form-control" disabled="true" rows="4"><?= $model->PHUKIEN ; ?></textarea>
                        </div>
                    </p>

                    <?php Pjax::begin(); ?>  
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "{items}{pager}",
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'MA_NOIDUNG',
                                'NOIDUNG',
                                [
                                    'attribute' => 'CHUKY',
                                    'value' => function ($model) {
                                        return $model->CHUKY . ' tháng';
                                    }
                                ],
                                [
                                    'attribute' => 'QLTRAM',
                                    'value' => function ($model) {
                                        return ($model->QLTRAM) ? 'Quản lý trạm' : 'Đội BDUCTT';
                                    }
                                ],
                                [
                                    'attribute' => 'YEUCAUNHAP',
                                    'value' => function ($model) {
                                        return ($model->YEUCAUNHAP !== "0" ) ? $model->YEUCAUNHAP : "Đạt/Không đạt" ;
                                    }
                                ],
                            ],
                        ]); ?>
                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
<?php
$script = <<< JS
    $( document ).ready(function() {
        typeChange();
        $('#noidungbaotri-type').change(function(){
            typeChange();
        })
    });
    function typeChange(){
        var type = $('#noidungbaotri-type').val();
        if(type == 0){
            $('#yeucaunhap').hide();
        }
        if(type == 1){
            $('#yeucaunhap').show();
        }
    }
JS;
$this->registerJs($script);
?>