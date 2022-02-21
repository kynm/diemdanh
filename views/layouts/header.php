<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="<?= Url::to(['/'])?>" class="navbar-brand">Dashboard</a>
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
                                <li><a href="<?= Url::to(['nhanvien/index'])?>">Nhân viên</a></li>
                                <li><a href="<?= Url::to(['/admin'])?>">Phân quyền</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="active"><a href="<?= Url::to(['baohong/index'])?>">Báo hỏng</a></li>
                </ul>
            </div>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <span class="hidden-xs"><?= Yii::$app->user->identity->nhanvien->TEN_NHANVIEN ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= Url::to(['user/edit-profile'])?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= Url::to(['site/logout'])?>" data-method="post">
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
