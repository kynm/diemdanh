<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::getAlias('@web') ?>/<?= Yii::$app->user->identity->avatar ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>
                    <?= Yii::$app->user->identity->nhanvien->TEN_NHANVIEN ?>
                </p>
                <!-- Status -->
                <a href="#" data-method="post"><i class="fa fa-user-o"></i><?= Yii::$app->user->identity->nhanvien->chucvu->ten_chucvu ?></a>
            </div>
        </div>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'MENU', 'options' => ['class' => 'header']],
                    ['label' => 'Công việc cá nhân', 'icon' => 'wrench', 'url' => Url::to(['congviec/'])],
                    [
                        'label' => 'Các đợt bảo dưỡng',
                        'icon' => 'table',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Thêm đợt bảo dưỡng', 'icon' => 'plus', 'url' => Url::to(['dotbaoduong/taodotbaoduong'])],
                            ['label' => 'Kế hoạch', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/danhsachkehoach'])],
                            ['label' => 'Đang thực hiện', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/danhsachthuchien'])],
                            ['label' => 'Kết thúc', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/danhsachketqua'])],
                        ],
                    ],
                    [
                        'label' => 'Đơn vị',
                        'icon' => 'building-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Danh sách đơn vị', 'icon' => 'caret-right', 'url' => Url::to(['donvi/'])],
                            ['label' => 'Danh sách đài viễn thông', 'icon' => 'caret-right', 'url' => Url::to(['daivt/'])],
                            ['label' => 'Danh sách nhân viên', 'icon' => 'caret-right', 'url' => Url::to(['nhanvien/'])],
                        ]
                    ],
                    [
                        'label' => 'Quản lý thiết bị',
                        'icon' => 'tablet',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Nhóm thiết bị', 'icon' => 'caret-right', 'url' => Url::to(['nhomtbi/'])],
                            // ['label' => 'Loại thiết bị', 'icon' => 'caret-right', 'url' => Url::to(['thietbi/'])],
                            ['label' => 'Thiết bị theo trạm', 'icon' => 'caret-right', 'url' => Url::to(['tramvt/'])],
                        ]
                    ],
                    ['label' => 'Thông tin cá nhân', 'icon' => 'user', 'url' => Url::to(['user/edit-profile'])],
                ],
            ]
        ) ?>

    </section>

</aside>
