<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="<?= Url::to(['/'])?>" class="navbar-brand">TRANG CHỦ</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="navbar-collapse pull-left collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php if (Yii::$app->user->can('Administrator')): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Quản trị <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?= Url::to(['donvi/index'])?>">Đơn vị</a></li>
                                    <li><a href="<?= Url::to(['nhanvien/index'])?>">Nhân viên</a></li>
                                    <li><a href="<?= Url::to(['/admin'])?>">Phân quyền</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">HƯỚNG DẪN<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php if (Yii::$app->user->can('Administrator') || Yii::$app->user->can('quanlyhocsinh')): ?>
                                    <li><a href="https://docs.google.com/document/d/1uYMzSlUt7E9Zu2qf2hMxrszn0LZ8PE7CzvuHL8pDVOI/edit?usp=sharing" target="_blank">QUẢN LÝ TRUNG TÂM</a></li>
                                <?php endif; ?>
                                    <li><a href="https://docs.google.com/document/d/1mGWRUdnxj4CLGiNJbLctc57NmPYJ0A4RsQs-hORecxY/edit?usp=sharing" target="_blank">ĐIỂM DANH</a></li>
                            </ul>
                        </li>
                </ul>
            </div>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <span><?= Yii::$app->user->identity->nhanvien->TEN_NHANVIEN ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= Url::to(['user/edit-profile'])?>" class="btn btn-default btn-flat">Profile</a>
                                <?php if (Yii::$app->user->can('quanlyhocsinh')): ?>
                                    <a href="<?= Url::to(['user/cauhinhdonvi'])?>" class="btn btn-default btn-flat">CẤU HÌNH</a>
                                <?php endif; ?>
                            </div>
                            <div class="pull-right">
                                <a href="<?= Url::to(['site/logout'])?>" data-method="post" class="btn btn-default btn-flat">
                                    <i class="fa fa-sign-out"></i> Đăng xuất
                                </a>
                            </div>
                        </li>
                    </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header> 
