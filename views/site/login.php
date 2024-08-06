<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
    
<div class="login-form">

    <div class="col-sm-4 col-sm-offset-4">
        
        <img class="img-responsive" style="margin-bottom: 10px; vertical-align: middle" src="<?= Url::to(Yii::$app->homeUrl) ?>dist/img/logo.png">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                // 'labelOptions' => ['class' => 'col-sm-1 control-label'],
            ],
        ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => false, 'placeholder' => 'Tên đăng nhập' ])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Mật khẩu' ])->label(false) ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "{input} {label}\n{error}",
            ]) ?>

            <div class="form-group">
                <div class="text-center">
                    <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary btn-flat', 'name' => 'login-button']) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

        <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"> <a href="https://www.facebook.com/easycheckvn" target="_blank"><i class="fa fa-facebook" style="font-size: 36px;"></i> LIÊN HỆ VỚI CHÚNG TÔI QUA FACEBOOK</a>
        </div>
    </div>

</div>