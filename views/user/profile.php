<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\Nhanvien;
use app\models\AuthItem;
use app\models\Donvi;
use app\models\Daivt;
use kartik\select2\Select2;

$this->title = 'Thông tin cá nhân';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($alert != ''): ?>
  <div class="alert alert-info text-center">
    <b><?= $alert ?></b>
  </div>
<?php endif; ?>
<div class="row">
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" id="avatar" src="<?= Yii::getAlias('@web') ?>/<?= Yii::$app->user->identity->avatar ?>" alt="User profile picture" style="height: 100px" > 

        <h3 class="profile-username text-center"><?= $nhanvien->TEN_NHANVIEN ?></h3>

        <p class="text-muted text-center"><?= $nhanvien->chucvu->ten_chucvu ?></p>
        
        <div class="btn btn-default btn-file btn-block btn-flat">
            <i class="fa fa-image"></i> Chọn ảnh đại diện
            <input type="file" name="User[file]" id="user-file" accept="image/*">
        </div> <br>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <label>Đổi mật khẩu</label>
            <div class="form-group">
                <?= $form->field($user, 'password')->passwordInput(['placeholder' => 'Nhập mật khẩu' ])->label(false) ?>
            </div>
            <div class="form-group">
                <?= $form->field($user, 'newPassword')->passwordInput(['placeholder' => 'Nhập mật khẩu mới' ])->label(false) ?>
            </div>
            <div class="form-group">
                <?= $form->field($user, 'confirmPassword')->passwordInput(['placeholder' => 'Xác nhận mật khẩu' ])->label(false) ?>
                <span id='message'></span>
            </div>
          </li>
        </ul>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="box box-primary">
      <div class="box-body">
          <div class="col-sm-4 col-md-4"> 
            <?= $form->field($nhanvien, 'USER_NAME')->textInput(['maxlength' => true, 'disabled' => true]) ?>
          </div>

          <div class="col-sm-4 col-md-4"> 
            <?= $form->field($nhanvien, 'TEN_NHANVIEN')->textInput(['maxlength' => true, 'disabled' => true]) ?>
          </div>

          <div class="col-sm-4 col-md-4"> 
            <?= $form->field($nhanvien->chucvu, 'ten_chucvu')->textInput(['maxlength' => true, 'disabled' => true]) ?>
          </div>

          <div class="col-sm-4 col-md-4"> 
            <?= $form->field($nhanvien, 'ID_DONVI')->dropDownList(
                ArrayHelper::map(Donvi::find()->all(), 'ID_DONVI', 'TEN_DONVI'),
                ['prompt' => 'Chọn đơn vị chủ quản' , 'disabled' => true]
            ) ?>
          </div>
          <div class="col-sm-4 col-md-4"> 
            <?= $form->field($nhanvien, 'DIEN_THOAI')->textInput(['maxlength' => true]) ?>
          </div>
    
          <div class="col-sm-4 col-md-4"> 
            <?= $form->field($nhanvien, 'GHI_CHU')->textInput(['maxlength' => true]) ?>
          </div>
        
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
          <div class="text-center">
            <?= Html::a('<i class="fa fa-reply"></i> Trở về', Url::to(['site/index']), ['class' => 'btn btn-danger btn-flat']) ?>
            <?= Html::submitButton('<i class="fa fa-save"></i> Lưu', ['class' => 'btn btn-primary btn-flat']) ?>
          </div>
      </div>
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
  <?php ActiveForm::end(); ?>
</div>
<?php
$script = <<< JS
  function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#avatar').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#user-file").change(function() {
    readURL(this);
  });

  $('#user-newpassword, #user-confirmpassword').on('keyup', function () {
    if ($('#user-password').val() == '') {
      $('#message').html('Chưa nhập mật khẩu cũ').css('color', 'red');
    } else {
      if ($('#user-newpassword').val() == $('#user-confirmpassword').val()) {
        $('#message').html('Khớp mật khẩu').css('color', 'green');
      } else 
        $('#message').html('Không khớp mật khẩu').css('color', 'red');
      }
    }
  );

JS;
$this->registerJs($script);
?>