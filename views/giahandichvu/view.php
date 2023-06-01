<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = $model->TEN_KH;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['hoadondientumoi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị chủ quản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-view">

    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Tiếp xúc khách hàng', ['tiepxuckhachhang', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'DICHVU_ID',
                    'TEN_KH',
                    'MST',
                    'DIACHI',
                    [
                        'attribute' => 'LIENHE',
                        'value' => Html::a($model->LIENHE,"tel:".$model->LIENHE),
                        'format' => 'raw',
                    ],
                    'EMAIL',
                    'ghichu',
                    'TEN_NV_KD',
                ],
            ]) ?>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title btn btn-danger">HÌNH ẢNH</h3>
                    </div>
                    <div class="box-body">
                            <p id="b64"></p>
                        <ul class="anhgiahan">
                        <?php foreach ($khachhang->anhgiahan as $image): ?>
                            <a href="<?php echo $image->urlimage;?>">
                                <img  height="150"  src="<?php echo $image->urlimage;?>"></a>
                                <i class="fa fa-remove delete-image-dantem" style="color:red" data-id="<?=$image->id?>"></i>
                        <?php endforeach; ?>
                        </ul>
                        <input type="hidden" name="giahan_id" value="<?= $khachhang->id ?>" id="giahan_id">
                        <input type="button" id="load-anhgiahan" value="Thêm ảnh" onclick="document.getElementById('inp').click();" />
                        <input id="inp" type='file' accept="image/*" style="display:none;">
                        <?= $form->field($model, 'nhanvien_id')->hiddenInput(['value'=> $model->nhanvien_id])->label(false); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <?= $this->render('_lichsu_tiepxuc', [
        'lichsutiepxuc' => $model->lichsutiepxuc,
    ]) ?>
</div>
<?php
$script = <<< JS
    $('.anhgiahan').magnificPopup({
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
