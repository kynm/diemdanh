<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
// print_r($exception);
// die();
switch ($exception->statusCode) {
    case '403':
        $errMessage = 'Bạn không có quyền truy cập trang này.';
        break;
    
    case '404':
        $errMessage = 'Trang bạn yêu cầu không có.';
        break;
    
    case '500':
        $errMessage = 'Đã xảy ra lỗi từ server.';
        break;
    
    default:
        $errMessage = 'Website đang gặp lỗi.';
        break;
}
?>
    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> <?= $exception->statusCode ?></h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Có lỗi xảy ra.</h3>

          <p>
            <?=  $errMessage ?>
            <br/>
            Vui lòng trở về trang chủ.
          </p>
          <a class="btn btn-default btn-flat" href="<?= Url::to(['site/']) ?>"> <i class="fa fa-home"></i> Về trang chủ</a>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->