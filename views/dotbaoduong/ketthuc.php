<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\widgets\Pjax;
use app\models\Nhanvien;
use app\models\User;
use app\models\Thuchienbd;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DotbaoduongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kết quả đợt '.$model->MA_DOTBD;
$this->params['breadcrumbs'][] = ['label' => 'Dotbaoduongs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dotbaoduong-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="form-inline">
        <div class="form-group col-md-3 col-sm-6">
            <label>Trạm viễn thông</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->iDTRAMVT->MA_TRAM ; ?>">
        </div>
        <div class="form-group col-md-3 col-sm-6">
            <label>Ngày bảo dưỡng</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->NGAY_BD ; ?>">
        </div>
        <div class="form-group col-md-3 col-sm-6">
            <label>Nhóm trưởng</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->tRUONGNHOM->TEN_NHANVIEN ; ?>">
        </div>
        <div class="form-group col-md-3 col-sm-6">
            <label>Trạng thái</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->TRANGTHAI ; ?>">
        </div>
    </p>

    <p> 
        <?php $form = ActiveForm::begin(); ?>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <?php
            $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->email])->one();

            if ($model->TRUONG_NHOM == $nhanvien->ID_NHANVIEN) {
                
                echo Html::submitButton(
                    '<i class="glyphicon glyphicon-check"></i> Đánh gía đợt bảo dưỡng', 
                    ['class'=>'btn btn-primary']
                ) ;                    
             
            }
    ?>
    </p>
<?= GridView::widget([
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
    ]); ?>
<?php ActiveForm::end(); ?></div>
