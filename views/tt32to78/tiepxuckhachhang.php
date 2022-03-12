<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = 'Tiếp xúc khách hàng';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['hoadondientumoi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị chủ quản', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $khachhang->TEN_KH, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Cập nhật';

?>
<div class="donvi-update">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-md-12">
                <div class="box-body box-profile">
                    <P class="text-center"><b><?=$khachhang->TEN_KH?><b></P>
                    <p class="text-muted text-center"><b><?=$khachhang->DIACHI?><b></p>
                    <p class="text-muted text-center"><i class="fa fa-phone"></i><a href="tel:<?=$khachhang->LIENHE?>" class="text-center"><b><?=$khachhang->LIENHE?></b></a></p>
                    <p class="text-muted text-center"><?=$khachhang->EMAIL?></p>
                    <p class="text-muted text-center"><?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật thông tin khách hàng', ['update', 'id' => $khachhang->id], ['class' => 'btn btn-primary btn-flat']) ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'ht_tc')->widget(Select2::classname(), [
                        'data' => hinhthuctx(),
                        'pluginOptions' => [
                            'placeholder' => 'Hình thức tiếp cận',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div> 
                <div class="col-md-2">
                    <?= $form->field($model, 'ketqua')->widget(Select2::classname(), [
                        'data' => ketqua32to78(),
                        'pluginOptions' => [
                            'placeholder' => 'Kết quả',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
                </div> 
                <div class="col-md-8">
                    <?= $form->field($model, 'ghichu')->textarea(['rows' => '6']) ?>
                </div>
            </div>
        </div>
            
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    <?= $this->render('_lichsu_tiepxuc', [
        'lichsutiepxuc' => $khachhang->lichsutiepxuc,
    ]) ?>
</div>
