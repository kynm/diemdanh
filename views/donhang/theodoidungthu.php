<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'THÔNG TIN HỆ THỐNG TRONG NGÀY';
?>
<div class="box-body table-responsive">
    <h3>ĐƠN VỊ THỬ NGHIỆM ĐÃ TẠO TRONG NGÀY</h3>
    <table class="table table-bordered">
        <tbody>
            <tr class="bg-primary">
                <th class="text-center">ĐƠN VỊ</th>
                <th class="text-center">SỐ ĐIỆN THOẠI</th>
            </tr>
            <?php
                foreach ($dsdonvi as $key => $value):
            ?>
                <tr>
                    <td><?= $value['TEN_DONVI']?></td>
                    <td class="text-center"><?= $value['SO_DT']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="box-body table-responsive">
    <h3>LỚP HỌC ĐÃ TẠO TRONG NGÀY</h3>
    <table class="table table-bordered">
        <tbody>
            <tr class="bg-primary">
                <th class="text-center">ĐƠN VỊ</th>
                <th class="text-center">SỐ ĐIỆN THOẠI</th>
                <th class="text-center">LỚP</th>
            </tr>
            <?php
                    foreach ($dslophoc as $key => $value):
                    ?>
                    <tr>
                        <td><?= $value['TEN_DONVI']?></td>
                        <td class="text-center"><?= $value['SO_DT']?></td>
                        <td class="text-center"><?= $value['TEN_LOP']?></td>
                    </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="box-body table-responsive">
    <h3>HỌC SINH ĐÃ TẠO TRONG NGÀY</h3>
    <table class="table table-bordered">
        <tbody>
            <tr class="bg-primary">
                <th class="text-center">ĐƠN VỊ</th>
                <th class="text-center">SỐ ĐIỆN THOẠI</th>
                <th class="text-center">LỚP</th>
                <th class="text-center">HỌC SINH</th>
            </tr>
            <?php
                    foreach ($dshocsinh as $key => $value):
                    ?>
                    <tr>
                        <td><?= $value['TEN_DONVI']?></td>
                        <td class="text-center"><?= $value['SO_DT']?></td>
                        <td class="text-center"><?= $value['TEN_LOP']?></td>
                        <td class="text-center"><?= $value['HO_TEN']?></td>
                    </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="box-body table-responsive">
    <h3>LƯỢT ĐIỂM DANH</h3>
    <table class="table table-bordered">
        <tbody>
            <tr class="bg-primary">
                <th class="text-center">ĐƠN VỊ</th>
                <th class="text-center">SỐ ĐIỆN THOẠI</th>
                <th class="text-center">LỚP</th>
                <th class="text-center">HỌC SINH</th>
            </tr>
            <?php
                foreach ($dsdiemdanh as $key => $value):
            ?>
                <tr>
                    <td><?= $value['TEN_DONVI']?></td>
                    <td class="text-center"><?= $value['SO_DT']?></td>
                    <td class="text-center"><?= $value['TEN_LOP']?></td>
                    <td class="text-center"><?= $value['NGAY_DIEMDANH']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


