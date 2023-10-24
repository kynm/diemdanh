<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */
/* @var $form yii\widgets\ActiveForm */
$ketqua = ketquasuamau();
if (Yii::$app->user->can('nhanvienkinhdoanh')) {
    unset($ketqua[2]);
} elseif(Yii::$app->user->can('nhanvienkithuat')) {
    unset($ketqua[0]);
    unset($ketqua[1]);
    unset($ketqua[3]);
    unset($ketqua[4]);

}
?>

<div class="donvi-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'ketqua')->radioList($ketqua);; ?>
                </div>
                <?php if(Yii::$app->user->can('nhanvienkinhdoanh')): ?>
                    <div class="col-md-12">
                        <?= $form->field($model, 'ghichu')->textarea(['rows' => '6']) ?>
                    </div>
                <?php endif; ?>
                <?php if(Yii::$app->user->can('nhanvienkithuat')): ?>
                    <div class="col-md-12">
                        <?= $form->field($model, 'ghichu_xl')->textarea(['rows' => '6']) ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
                    <input type="hidden" name="chuanhoa_id" value="<?= $model->id ?>" id="chuanhoa_id">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title btn btn-danger">HÌNH ẢNH MẪU HÓA ĐƠN TRƯỚC CHUẨN HÓA</h3>
                </div>
                <div class="box-body">
                        <p id="b64"></p>
                    <ul class="anhtruocchuanhoa">
                    <?php foreach ($model->anhtruocchuanhoa as $image): ?>
                        <a href="<?php echo $image->urlimage;?>">
                            <img  height="150"  src="<?php echo $image->urlimage;?>"></a>
                            <i class="fa fa-remove delete-image-dantem" style="color:red" data-id="<?=$image->id?>"></i>
                    <?php endforeach; ?>
                    </ul>
                    <input type="button" id="load-anhtruocchuanhoa" value="Thêm ảnh" onclick="document.getElementById('truocchuanhoa').click();" />
                    <input id="truocchuanhoa" type='file' accept="image/*" style="display:none;">
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title btn btn-danger">HÌNH ẢNH MẪU HÓA ĐƠN SAU CHUẨN HÓA</h3>
                </div>
                <div class="box-body">
                        <p id="b64"></p>
                    <ul class="anhsauchuanhoa">
                    <?php foreach ($model->anhsauchuanhoa as $image): ?>
                        <a href="<?php echo $image->urlimage;?>">
                            <img  height="150"  src="<?php echo $image->urlimage;?>"></a>
                            <i class="fa fa-remove delete-image-dantem" style="color:red" data-id="<?=$image->id?>"></i>
                    <?php endforeach; ?>
                    </ul>
                    <input type="button" id="load-anhsauchuanhoa" value="Thêm ảnh" onclick="document.getElementById('sauchuanhoa').click();" />
                    <input id="sauchuanhoa" type='file' accept="image/*" style="display:none;">
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
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
                var chuanhoa_id = $("#chuanhoa_id").val();
                var type = 1;
                $.ajax({
                    url: '/chuanhoamauhoadon/uploadbase64v2',
                    method: 'POST',
                    data: {
                        IMAGEBASE64: dataUrl,
                        chuanhoa_id: chuanhoa_id,
                        type: type,
                    },
                    success:function(data) {
                        data = jQuery.parseJSON(data);
                        if (data.error == 0) {
                            $(".anhtruocchuanhoa").append('<a href="' + data.image_url + '"><img height="150" src="' + data.image_url + '"></a><i class="fa fa-remove delete-image-giahan" style="color:red" data-id="' + data.id + '"></i>');
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
function readFile1() {
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
                var chuanhoa_id = $("#chuanhoa_id").val();
                var type = 2;
                $.ajax({
                    url: '/chuanhoamauhoadon/uploadbase64v2',
                    method: 'POST',
                    data: {
                        IMAGEBASE64: dataUrl,
                        chuanhoa_id: chuanhoa_id,
                        type: type,
                    },
                    success:function(data) {
                        data = jQuery.parseJSON(data);
                        if (data.error == 0) {
                            $(".anhsauchuanhoa").append('<a href="' + data.image_url + '"><img height="150" src="' + data.image_url + '"></a><i class="fa fa-remove delete-image-giahan" style="color:red" data-id="' + data.id + '"></i>');
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

    document.getElementById("truocchuanhoa").addEventListener("change", readFile);
    document.getElementById("sauchuanhoa").addEventListener("change", readFile1);

    $('.anhtruocchuanhoa').magnificPopup({
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
