<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $model->ma_tb;
$this->params['breadcrumbs'][] = ['label' => 'Báo hỏng', 'url' => ['baohong/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <div class="box-footer">
        <?=  Html::a('Gửi lại tin nhắn khởi tạo', ['guilaitinnhan', 'id' => $model->id, 'type' => 'create-baohong'], ['class' => 'btn btn-danger btn-flat']) ?>
        <?=  Html::a('Gửi lại tin nhắn xử lý', ['xulybaohong', 'id' => $model->id, 'type' => 'capnhatxuly-baohong'], ['class' => 'btn btn-danger btn-flat']) ?>
        <?=  Html::a('Gửi lại tin nhắn phản hồi',[ 'xulybaohong', 'id' => $model->id, 'type' => 'phanhoixuly-baohong'], ['class' => 'btn btn-danger btn-flat']) ?>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <?= $this->render('_detail', [
                'model' => $model,
            ]) ?>
            <div class="box-footer">
                <?php if (in_array($model->status, [0,2])): ?>
<!--                     <span class="btn btn-primary" data-matb="<?php echo $model->ma_tb?>" id="kttrangthaithuebao">Kiểm tra trạng thái thuê bao</span>
                    <span class="btn btn-primary" data-matb="<?php echo $model->ma_tb?>" id="ktttthuebao">KTTT thuê bao</span> -->
                    <?php if (Yii::$app->user->can('dmdv-xlbaohong') || (Yii::$app->user->can('xuly-baohong') && Yii::$app->user->identity->nhanvien->ID_NHANVIEN == $model->nhanvien_xl_id)): ?>
                        <?=  Html::a('Xử lý báo hỏng', ['xulybaohong', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (Yii::$app->user->can('nhanvien-kd-baohong') && in_array($model->status, [1,3]) && ($model->nhanvien_id == Yii::$app->user->identity->nhanvien->ID_NHANVIEN)): ?>
                    <?=  Html::a('Phản hồi xử lý', ['phanhoixuly', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
// $this->registerJsFile('/js/xulybaohong.js'); 
 ?>