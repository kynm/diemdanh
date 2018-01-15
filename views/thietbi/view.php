<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Noidungbaotri;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Thietbi;

/* @var $this yii\web\View */
/* @var $model app\models\Thietbi */

$this->title = $model->ID_THIETBI;
$this->params['breadcrumbs'][] = ['label' => 'Thiết bị', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thietbi-view">

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
            <input type="text" class="form-control" disabled="true" value="<?= $model->iDNHOMTB->TEN_NHOM ; ?>">
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

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Thêm nội dung bảo trì', ['noidungbaotri/create', 'id' => $model->ID_THIETBI], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'MA_NOIDUNG',
                ['attribute' => 'ID_THIETBI', 'value' => 'iDTHIETBI.TEN_THIETBI'],
                'NOIDUNG',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',

                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url ='index.php?r=noidungbaotri/view&id='.$key;
                            return $url;
                        }
                        if ($action === 'update') {
                            $url ='index.php?r=noidungbaotri/update&id='.$key;
                            return $url;
                        }
                        if ($action === 'delete') {
                            $url ='index.php?r=noidungbaotri/delete&id='.$key;
                            return $url;
                        }
                    }
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>

</div>
