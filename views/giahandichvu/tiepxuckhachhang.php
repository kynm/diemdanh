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
                        'data' => ketquagiahan(),
                        'pluginOptions' => [
                            'placeholder' => 'Kết quả',
                            'allowClear' => true,
                            // 'multiple' => true
                        ],
                    ]); ?>
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
<?php
$script = <<< JS
function readFile() {
    if (this.files && this.files[0]) {
        var FR= new FileReader();
        FR.addEventListener("load", function(e) {
        // document.getElementById("img").src = e.target.result;
            var width = 500;
            var height = 300;
            var image = new Image();
            image.src = e.target.result;
            var dataURLToBlob = function(dataURL) {
                var BASE64_MARKER = ';base64,';
                if (dataURL.indexOf(BASE64_MARKER) == -1) {
                    var parts = dataURL.split(',');
                    var contentType = parts[0].split(':')[1];
                    var raw = parts[1];
                    return new Blob([raw], {type: contentType});
                }
                var parts = dataURL.split(BASE64_MARKER);
                var contentType = parts[0].split(':')[1];
                var raw = window.atob(parts[1]);
                var rawLength = raw.length;
                var uInt8Array = new Uint8Array(rawLength);
                for (var i = 0; i < rawLength; ++i) {
                    uInt8Array[i] = raw.charCodeAt(i);
                }
                return new Blob([uInt8Array], {type: contentType});
            }
            image.onload = () => {
                // Resize the image
                var canvas = document.createElement('canvas'),
                    max_size = 800,// TODO : pull max size from a site config
                    width = image.width,
                    height = image.height;
                if (width > height) {
                    if (width > max_size) {
                        height *= max_size / width;
                        width = max_size;
                    }
                } else {
                    if (height > max_size) {
                        width *= max_size / height;
                        height = max_size;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                var dataUrl = canvas.toDataURL('image/jpeg');
                var resizedImage = dataURLToBlob(dataUrl);
                var giahan_id = $("#giahan_id").val();
                $.ajax({
                    url: '/giahandichvu/uploadbase64v2',
                    method: 'POST',
                    data: {
                        IMAGEBASE64: dataUrl,
                        giahan_id: giahan_id,
                    },
                    success:function(data) {
                        data = jQuery.parseJSON(data);
                        if (data.error == 0) {
                            $(".anhgiahan").append('<a href="' + data.image_url + '"><img height="150" src="' + data.image_url + '"></a><i class="fa fa-remove delete-image-giahan" style="color:red" data-id="' + data.id + '"></i>');
                            Swal.fire({
                                icon: 'success',
                                title: 'Upload ảnh thành công',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi upload ảnh',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        }
                        return 1;
                    }
                });
            };
            FR.onerror = error => console.log(error);
        });
        FR.readAsDataURL( this.files[0] );
    }
}

    document.getElementById("inp").addEventListener("change", readFile);

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
