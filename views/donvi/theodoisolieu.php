<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'THÔNG TIN HỆ THỐNG TRONG NGÀY';
?>
<div class="box-body table-responsive">
    <h3>HỌC SINH KHỞI TẠO TRONG NGÀY</h3>
    <table class="table table-bordered">
        <tbody>
            <tr class="bg-primary">
                <th class="text-center">ĐƠN VỊ</th>
                <th class="text-center">SỐ ĐIỆN THOẠI</th>
                <th class="text-center">SỐ HỌC SINH</th>
            </tr>
            <?php
                foreach ($hocsinhtaotrongngay as $key => $value):
            ?>
                <tr>
                    <td><?= $value['TEN_DONVI']?></td>
                    <td class="text-center"><?= $value['SO_DT']?></td>
                    <td class="text-center"><?= $value['SOLUONG']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="box-body table-responsive">
    <h3>ĐIỂM DANH TRONG NGÀY</h3>
    <table class="table table-bordered">
        <tbody>
            <tr class="bg-primary">
                <th class="text-center">ĐƠN VỊ</th>
                <th class="text-center">SỐ ĐIỆN THOẠI</th>
                <th class="text-center">SỐ LƯỢNG</th>
            </tr>
            <?php
                foreach ($diemdanhtrongngay as $key => $value):
            ?>
                <tr>
                    <td><?= $value['TEN_DONVI']?></td>
                    <td class="text-center"><?= $value['SO_DT']?></td>
                    <td class="text-center"><?= $value['SOLUONG']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>