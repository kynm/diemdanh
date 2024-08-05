<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'QUẢN LÝ ĐIỂM DANH';
?>
    <?php if (Yii::$app->user->identity->nhanvien->iDDONVI->STATUS == 1):?>
        <?php if (!$solop):?>
            <h5 class="info-box-number" style="color: red"><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i>HIỆN BẠN CHƯA CÓ LỚP HỌC NÀO, VUI LÒNG TẠO LỚP HỌC ĐỂ BẮT ĐẦU SỬ DỤNG!</h5>
        <?php elseif (!$tongsohocvien):?>
            <h5 class="info-box-number" style="color: red"><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i>HIỆN BẠN CHƯA CÓ HỌC SINH NÀO, VUI LÒNG QUAY LẠI TẠO HỌC SINH CHO LỚP HỌC!</h5>
        <?php else: ?>
            <h5  class="info-box-number" style="color: red"><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i>BẠN ĐÃ TẠO THÀNH CÔNG LỚP HỌC VÀ HỌC SINH. VÙI LÒNG ĐĂNG XUẤT KHỎI TÀI KHOẢN QUẢN TRỊ VÀ THỰC HIỆN ĐIỂM DANH BẰNG TÀI KHOẢN ĐIỂM DANH!</h4>
            <div><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i>
                <a href="<?= Url::to(['site/logout'])?>" data-method="post" class="btn btn-default btn-danger btn-flat" style="color: white;">
                   <i class="fa fa-sign-out"></i> Đăng xuất ngay
                </a>
            </div>
            <br>
            <br>
            <br>
        <?php endif; ?>
    <?php endif; ?>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-address-book" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;"><?= $solop?> LỚP HỌC</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> DANH SÁCH LỚP HỌC', ['/lophoc/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;"><?= $tongsohocvien?> HỌC VIÊN</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> DANH SÁCH HỌC VIÊN', ['/hocsinh/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;"><?= $sonhanvien?> NHÂN VIÊN</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i>DANH SÁCH NHÂN VIÊN ', ['/nhanvien/dsnhanviendonvi'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;">THEO DÕI ĐIỂM DANH</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> DANH SÁCH ĐIỂM DANH', ['/quanlydiemdanh/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <?php if (Yii::$app->user->can('quanlyhocphi')):?>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;">THU HỌC PHÍ (THEO THÁNG)</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> QUẢN LÝ THU HỌC PHÍ', ['/quanlyhocphi/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;">QUẢN LÝ HỌC PHÍ THU TRƯỚC</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> QUẢN LÝ HỌC PHÍ THU TRƯỚC', ['/quanlyhocphithutruoc/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<div class="box-body table-responsive">
    <h3>ĐIỂM DANH NGÀY HÔM NAY</h3>
    <table class="table table-bordered">
        <tbody>
            <tr class="bg-primary">
                <th class="text-center">LỚP</th>
                <th class="text-center">TỔNG SỐ HỌC SINH</th>
                <th class="text-center">SỐ HỌC SINH ĐI HỌC</th>
                <th class="text-center">SỐ HỌC SINH VẮNG</th>
                <th class="text-center">HỌC SINH VẮNG</th>
            </tr>
            <?php
                $SOHOCSINH = 0;
                $SOLUONGDIHOC = 0;
                $SOLUONGNGHI = 0;
                    foreach ($dulieungay as $key => $value):
                        $SOHOCSINH += $value['SOHOCSINH'];
                        $SOLUONGDIHOC += $value['SOLUONGDIHOC'];
                        $SOLUONGNGHI += $value['SOLUONGNGHI'];
                    ?>
                    <tr>
                        <td><?= $value['TEN_LOP']?></td>
                        <td class="text-center"><?= $value['SOHOCSINH']?></td>
                        <td class="text-center"><?= $value['SOLUONGDIHOC']?></td>
                        <td class="text-center"><?= $value['SOLUONGNGHI']?></td>
                        <td class="text-center"><?= $value['HOCSINHNGHI']?></td>
                    </tr>
                <?php endforeach; ?>
                <tr style="color:red">
                    <td>TỔNG</td>
                    <td class="text-center"><?= $SOHOCSINH?></td>
                    <td class="text-center"><?= $SOLUONGDIHOC?></td>
                    <td class="text-center"><?= $SOLUONGNGHI?></td>
                </tr>
        </tbody>
    </table>
</div>
    <?php if (Yii::$app->user->identity->nhanvien->iDDONVI->STATUS == 1):?>
        <h3 class="text-danger text-center">TÀI KHOẢN THỬ NGHIỆM, ĐĂNG KÝ CHÍNH THỨC ĐỂ MỞ KHÓA CÁC TÍNH NĂNG:<?= Html::a('<i class="fa fa-arrow-circle-right"></i> MUA GÓI', ['/donhang/donvimuagoi'], ['class' => 'small-box-footer']) ?><h3>
    <?php endif; ?>
