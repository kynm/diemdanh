<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'CÔNG CỤ HỖ TRỢ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number" style="font-size: 20px; color: red;"><?= Html::a('ĐẾM SỐ NGÀY TRONG TUẦN', ['/site/tinhngay'], ['class' => 'small-box-footer']) ?></span>
                
            </div>
        </div>
    </div>
</div>

</div>
