<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <span class="pull-right" ><b>Phiên bản</b> 1.0</span>
    </div>
    <strong><a>VNPT HÀ NAM , TRUNG TÂM CNTT</a> &copy; <?= date('Y', time()); ?></strong>
    <br>
    Địa chỉ: 144 Trần Phú, Quang Trung, Phủ Lý, Hà Nam.
    <br>
</footer>