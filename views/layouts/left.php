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
                    // [
                    //     'label' => 'Kiểm tra nhà trạm',
                    //     'icon' => 'wrench',
                    //     'url' => '#',
                    //     'items' => [
                    //         [
                    //             'label' => 'Danh sách', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/kiemtranhatram'])
                    //         ],
                    //         [
                    //             'label' => 'Báo cáo các đợt', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/baocaoktnt'])
                    //         ],
                    //     ],
                    // ],
                    // [
                    //     'label' => 'Phân công tổ trưởng',
                    //     'icon' => 'check-square-o',
                    //     'url' => Url::to(['congviec/giaonhiemvu']),
                    //     'visible' => Yii::$app->user->can('phancong-dbd')
                    // ],
                    // [
                    //     'label' => 'Bảo dưỡng thiết bị',
                    //     'icon' => 'table',
                    //     'url' => '#',
                    //     'items' => [
                    //         [
                    //             'label' => 'Thêm đợt bảo dưỡng', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/create'])
                    //         ],
                    //         [
                    //             'label' => 'Tổ trưởng giao việc', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/phe-duyet'])
                    //         ],
                    //         [
                    //             'label' => 'Danh sách', 'icon' => 'caret-right', 'url' => Url::to(['dotbaoduong/'])
                    //         ],
                    //     ],
                    // ],
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
                                'label' => 'Trạm viễn thông', 'icon' => 'caret-right', 'url' => Url::to(['tramvt/'])
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
                            [
                                'label' => 'Quản lý thiết bị theo trạm', 'icon' => 'caret-right', 'url' => Url::to(['tramvt/hatangtram'])
                            ],
                            // [
                            //     'label' => 'Loại thiết bị', 'icon' => 'caret-right', 'url' => Url::to(['thietbi/'])
                            // ],
                            
                        ]
                    ],
                    [
                        'label' => 'Quản lý máy nổ',
                        'icon' => 'tablet',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Dashboard', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlymayno/baocaotonghoptheodv']),
                                'visible' => Yii::$app->user->can('bctonghop-qldien'),
                            ],
                            [
                                'label' => 'Tổng hợp nhiên liệu trong năm', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlymayno/baocaotonghoptheotram']),
                                'visible' => Yii::$app->user->can('bctonghop-qldien'),
                            ],
                            [
                                'label' => 'Điều hành máy nổ', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlymayno/']),
                                'visible' => Yii::$app->user->can('edit-nkmayno'),
                            ],
                            [
                                'label' => 'Tổng hợp nhiên liệu theo tháng', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlymayno/thongkeketoan']),
                                'visible' => Yii::$app->user->can('tkkt-mayno'),
                            ],
                            [
                                'label' => 'Chi tiết nhiên liệu theo tháng', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlymayno/thongkechitiet']),
                                'visible' => Yii::$app->user->can('tkct-mayno'),
                            ],
                            [
                                'label' => 'Báo cáo theo đài trạm', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlymayno/baocaodaitram']),
                                'visible' => Yii::$app->user->can('view-nkmayno'),
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
                                'label' => 'Dashboard', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/baocaotonghoptheodv']),
                                'visible' => Yii::$app->user->can('bctonghop-qldien'),
                            ],
                            [
                                'label' => 'Tổng hợp điện trong năm', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/baocaotonghoptheotram']),
                                'visible' => Yii::$app->user->can('bctonghop-qldien'),
                            ],
                            [
                                'label' => 'Các trạm vượt định mức', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/thongketramvuotdinhmuc']),
                                'visible' => Yii::$app->user->can('bctonghop-qldien'),
                            ],
                            [
                                'label' => 'Báo cáo sử dụng điện cùng kỳ', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/baocaocungky']),
                                'visible' => Yii::$app->user->can('bctonghop-qldien'),
                            ],
                            [
                                'label' => 'Điều hành điện', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/']),
                                'visible' => Yii::$app->user->can('list-qldien'),
                            ],
                            [
                                'label' => 'Cập nhật định mức', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/capnhatdinhmuc']),
                                'visible' => Yii::$app->user->can('dinhmuc-qldien'),
                            ],
                            [
                                'label' => 'Tổng hợp điện theo tháng', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/thongkesudungdien']),
                                'visible' => Yii::$app->user->can('ketoan-qldien'),
                            ],
                            [
                                'label' => 'Báo cáo điện theo tháng', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/baocaototrinh']),
                                'visible' => Yii::$app->user->can('ketoan-qldien'),
                            ],
                            [
                                'label' => 'Cập nhật thanh toán điện', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/capnhatthanhtoandien']),
                                'visible' => Yii::$app->user->can('updatett-qldien'),
                            ],
                            [
                                'label' => 'Báo cáo theo định mức', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlydien/baocaodientheomuc']),
                                'visible' => Yii::$app->user->can('updatett-qldien'),
                            ],

                        ],
                        'visible' => Yii::$app->user->can('view-qldien'),
                    ],
                    [
                        'label' => 'BC tổng hợp điện nhiên liệu',
                        'icon' => 'tablet',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'TH điện nhiên liệu trong năm', 'icon' => 'caret-right',
                                'url' => Url::to(['baocaotonghop/baocaotonghoptheotram']),
                                'visible' => Yii::$app->user->can('bctonghop-qldien'),
                            ],
                            [
                                'label' => 'BC điện nhiên liệu theo định mức', 'icon' => 'caret-right',
                                'url' => Url::to(['baocaotonghop/thongketramvuotdinhmuc']),
                                'visible' => Yii::$app->user->can('bctonghop-qldien'),
                            ],
                        ],
                        'visible' => Yii::$app->user->can('view-qldien'),
                    ],
                    [
                        'label' => 'Quản lý hợp đồng',
                        'icon' => 'tablet',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Nhập hợp đồng', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlyhopdong/']),
                                'visible' => Yii::$app->user->can('list-qlhopdong'),
                            ],
                            [
                                'label' => 'Tổng hợp phiếu thu', 'icon' => 'caret-right',
                                'url' => Url::to(['quanlyhopdong/thongkephieuthu']),
                                'visible' => Yii::$app->user->can('ketoan-qlhopdong'),
                            ],
                            // [
                            //     'label' => 'Báo cáo điện theo tháng', 'icon' => 'caret-right',
                            //     'url' => Url::to(['quanlyhopdong/baocaototrinh']),
                            //     'visible' => Yii::$app->user->can('ketoan-qlhopdong'),
                            // ],
                            // [
                            //     'label' => 'Cập nhật thanh toán điện', 'icon' => 'caret-right',
                            //     'url' => Url::to(['quanlyhopdong/capnhatthanhtoandien']),
                            //     'visible' => Yii::$app->user->can('updatett-qlhopdong'),
                            // ],
                        ],
                        'visible' => Yii::$app->user->can('view-qlhopdong'),
                    ],
                    [
                        'label' => 'Thông tin cá nhân', 'icon' => 'user', 'url' => Url::to(['user/edit-profile'])
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
