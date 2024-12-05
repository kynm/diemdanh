<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'QUẢN LÝ ĐIỂM DANH';
?>
<div class="row">
    <?php
    $donvi = Yii::$app->user->identity->nhanvien->iDDONVI;
        $date1=date_create($donvi->NGAY_KT);
        $date2= date_create(date('Y-m-d'));
        if ($date2 > $date1) {
    ?>
    <h1 class="info-box-number text-center" style="color: red"><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i><i class="fa fa-hand-o-right"></i>GÓI CƯỚC ĐÃ HẾT HẠN, VUI LÒNG LIÊN HỆ GIA HẠN ĐỂ TIẾP TỤC SỬ DỤNG DỊCH VỤ!</h1>
    <?php
        }
    ?>
    <?php if (Yii::$app->user->can('quanlytruonghoc')):?>
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
                <span class="info-box-number"  style="font-size: 20px; color: red;"><?= Yii::$app->user->can('khonghienthisoluong') ? '' : $tongsohocvien?> HỌC VIÊN</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> DANH SÁCH HỌC VIÊN', ['/hocsinh/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;"><?= Yii::$app->user->can('khonghienthisoluong') ? '' : $sonhanvien?> NHÂN VIÊN</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i>DANH SÁCH NHÂN VIÊN ', ['/nhanvien/dsnhanviendonvi'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;">QUẢN LÝ LỊCH HỌC</span>
                <?= Html::a('QUẢN LÝ LỊCH HỌC', ['/quanlylichhoc/index'], ['class' => 'small-box-footer']) ?>
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
    <?php endif; ?>
    <?php if (Yii::$app->user->can('quanlyhocphi') && Yii::$app->user->identity->nhanvien->iDDONVI->HPTT):?>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-money" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;">THU HỌC PHÍ (THEO THÁNG)</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> QUẢN LÝ THU HỌC PHÍ', ['/quanlyhocphi/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (Yii::$app->user->can('quanlyhocphi') && !Yii::$app->user->can('anquanlyhocphitheokhoa')):?>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-money" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;">THU HỌC PHÍ THEO KHÓA</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> QUẢN LÝ THU HỌC PHÍ', ['/hocphitheokhoa/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (Yii::$app->user->can('quanlyhocphi') && Yii::$app->user->identity->nhanvien->iDDONVI->HP_T):?>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-money" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;">QUẢN LÝ HỌC PHÍ THU TRƯỚC</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> QUẢN LÝ HỌC PHÍ THU TRƯỚC', ['/quanlyhocphithutruoc/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (Yii::$app->user->can('quanlytruonghoc') && Yii::$app->user->can('quanlyphuhuynh')):?>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;">QUẢN LÝ PHỤ HUYNH</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> DS PHỤ HUYNH', ['/quanlyphuhuynh/index'], ['class' => 'small-box-footer']) ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (Yii::$app->user->can('quanlytruonghoc') && Yii::$app->user->can('quanlytintuc')):?>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
            <div class="info-box-content">
                <span class="info-box-number"  style="font-size: 20px; color: red;">QUẢN LÝ TIN TỨC</span>
                <?= Html::a('<i class="fa fa-arrow-circle-right"></i> DS TIN TỨC', ['/quanlytintuc/index'], ['class' => 'small-box-footer']) ?>
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
<?php if (Yii::$app->user->can('quanlyhocphi') && Yii::$app->user->identity->nhanvien->iDDONVI->HPTT):?>
    <div class="text-center" style="color: red;font-size: 20px;">
        <span ><i class="fa fa-star"></i>HỌC SINH CHƯA THU HỌC PHÍ HÀNG THÁNG: <span style="color: red;font-size: 30px;"><?= $slhocphichuathu[0]['SOLUONG']?></span> HỌC SINH</span> <?= Html::a('CHI TIẾT', ['/quanlyhocphi/chitietthuhocphidonvi'], ['target' => '_blank']) ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->user->can('quanlyhocphi') && Yii::$app->user->identity->nhanvien->iDDONVI->HP_T):?>
    <div class="text-center" style="color: red;font-size: 20px;">
        <span ><i class="fa fa-star"></i>HỌC SINH CHƯA THU HỌC PHÍ (THU TRƯỚC): <span style="color: red;font-size: 30px;"><?= $slhocphithutruocchuathu[0]['SOLUONG']?></span> HỌC SINH</span> <?= Html::a('CHI TIẾT', ['/quanlyhocphithutruoc/index'], ['target' => '_blank']) ?>
        <br/><span><i class="fa fa-star"></i>HỌC SINH HẾT HỌC PHÍ (THEO BUỔI): <span style="color: red;font-size: 30px;"><?= $slhocsinhhethocphitheobuoi[0]['SOLUONG']?></span> HỌC SINH</span> <?= Html::a('CHI TIẾT', ['/quanlyhocphithutruoc/canhbaotheosobuoihoc'], ['target' => '_blank']) ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->user->can('canhbaohocphitheokhoa')):?>
    <div class="text-center" style="color: red;font-size: 20px;">
        <span ><i class="fa fa-star"></i>HỌC SINH CHƯA THU HỌC PHÍ: <span style="color: red;font-size: 30px;"><?= $slhocphithutruocchuathu[0]['SOLUONG']?></span> HỌC SINH</span> <?= Html::a('CHI TIẾT', ['/hocphitheokhoa/chitietthuhocphidonvi'], ['target' => '_blank']) ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->user->identity->nhanvien->iDDONVI->STATUS == 1):?>
    <h3 class="text-danger text-center">TÀI KHOẢN THỬ NGHIỆM, ĐĂNG KÝ CHÍNH THỨC ĐỂ MỞ KHÓA CÁC TÍNH NĂNG:<?= Html::a('<i class="fa fa-arrow-circle-right"></i> MUA GÓI', ['/donhang/donvimuagoi'], ['class' => 'small-box-footer']) ?><h3>
<?php endif; ?>
