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
                    [
                        'label' => 'MENU', 'options' => ['class' => 'header']
                    ],
                    [
                        'label' => 'Kiểm tra nhà trạm',
                        'icon' => 'wrench',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Danh sách', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/kiemtranhatram'])
                            ],
                            [
                                'label' => 'Báo cáo các đợt', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/baocaoktnt'])
                            ],
                        ],
                    ],
                    [
                        'label' => 'Phân công tổ trưởng',
                        'icon' => 'check-square-o',
                        'url' => Url::to(['congviec/giaonhiemvu']),
                        'visible' => Yii::$app->user->can('phancong-dbd')
                    ],
                    [
                        'label' => 'Bảo dưỡng thiết bị',
                        'icon' => 'table',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Thêm đợt bảo dưỡng', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/create'])
                            ],
                            [
                                'label' => 'Tổ trưởng giao việc', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/phe-duyet'])
                            ],
                            [
                                'label' => 'Danh sách', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/'])
                            ],
                        ],
                    ],
                    [
                        'label' => 'Đơn vị',
                        'icon' => 'building-o',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Danh sách đơn vị', 'icon' => 'caret-right', 'url' => Url::to(['donvi/'])
                            ],
                            [
                                'label' => 'Danh sách đài viễn thông', 'icon' => 'caret-right', 'url' => Url::to(['daivt/'])
                            ],
                            [
                                'label' => 'Danh sách nhân viên', 'icon' => 'caret-right', 'url' => Url::to(['nhanvien/'])
                            ],
                        ]
                    ],
                    [
                        'label' => 'Quản lý cơ sở hạ tầng',
                        'icon' => 'tablet',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Nhóm thiết bị', 'icon' => 'caret-right', 'url' => Url::to(['nhomtbi/'])
                            ],
                            // [
                            //     'label' => 'Loại thiết bị', 'icon' => 'caret-right', 'url' => Url::to(['thietbi/'])
                            // ],
                            [
                                'label' => 'Trạm viễn thông', 'icon' => 'caret-right', 'url' => Url::to(['tramvt/'])
                            ],
                        ]
                    ],
                    [
                        'label' => 'Quản lý máy nổ',
                        'icon' => 'tablet',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Điều hành máy nổ', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlymayno/']),
                                'visible' => Yii::$app->user->can('edit-nkmayno'),
                            ],
                            [
                                'label' => 'Thống kê kế toán', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlymayno/thongkeketoan']),
                                'visible' => Yii::$app->user->can('tkkt-mayno'),
                            ],
                        ],
                        'visible' => Yii::$app->user->can('view-nkmayno'),
                    ],
                    [
                        'label' => 'Quản lý điện',
                        'icon' => 'tablet',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Điều hành điện', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/']),
                                'visible' => Yii::$app->user->can('list-qldien'),
                            ],
                            [
                                'label' => 'Thống kê sử dụng điện', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/thongkesudungdien']),
                                'visible' => Yii::$app->user->can('ketoan-qldien'),
                            ],
                            [
                                'label' => 'Tờ trình viễn thông', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/baocaototrinh']),
                                'visible' => Yii::$app->user->can('ketoan-qldien'),
                            ],
                        ],
                        'visible' => Yii::$app->user->can('view-qldien'),
                    ],
                    [
                        'label' => 'Thông tin cá nhân', 'icon' => 'user', 'url' => Url::to(['user/edit-profile'])
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
