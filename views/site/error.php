<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3><?= $name ?></h3>

            <p>
                <?= nl2br(Html::encode($message)) ?>
            </p>

            <p>
              Vui lòng trở về trang chủ.
            </p>
            <a class="btn btn-default btn-flat" href="<?= Yii::$app->homeUrl ?>"> <i class="fa fa-home"></i> Về trang chủ</a>
        </div>
    </div>

</section>
