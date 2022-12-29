<div class="col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <h3><b>Lịch sử tiếp xúc</b></h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr class="bg-danger">
                        <th style="width: 10px">#</th>
                        <th>Ngày tiếp xúc</th>
                        <th>Nhân viên tiếp xúc</th>
                        <th>Hình thức tiếp xúc</th>
                        <th>Kết quả tiếp xúc</th>
                        <th>Ghi chú</th>
                    </tr>
                    <?php foreach ($lichsutiepxuc as $key => $value):?>
                        <tr>
                            <td scope="col"><?php echo ($key + 1)?></td>
                            <td scope="col"><?php echo $value->ngay_tiepxuc?>
                            <td scope="col"><?php echo $value->nhanvien->TEN_NHANVIEN?>
                            <td scope="col"><?php echo hinhthuctx()[$value->ht_tc]?>
                            <td scope="col"><?php echo ketquagiahan()[$value->ketqua]?>
                            <td scope="col"><?php echo $value->ghichu?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>