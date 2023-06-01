<div class="col-md-4">
    <div class="box">
        <div class="box-header with-border">
            <h3><b class="text text-danger"><?= $tendv?></b></h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr class="bg-primary">
                        <th style="width: 10px">#</th>
                        <th>TÊN NHÂN VIÊN</th>
                        <th>TỔNG MỤC TIÊU</th>
                        <th width="20%">KẾ HOẠCH THÁNG <?= date('m/Y')?></th>
                        <th>ĐÃ LH</th>
                        <th>ĐÃ GIA HẠN</th>
                        <th width="10%">TỶ LỆ GIA HẠN</th>
                    </tr>
                    <?php
                    $tongmuctieu = 0;
                    $tongmuctieuthang = 0;
                    $tongdalienhe = 0;
                    $tongdagiahan = 0;
                        ?>
                    <?php foreach ($data as $key => $value):?>
                        <?php
                    $tongdalienhe += $value['DALH'];
                    $tongdagiahan += $value['DAGIAHAN'];
                    $tongmuctieu += $value['TONG'];
                    $tongmuctieuthang += $value['KEHOACHTHANG'];
                        ?>
                        <tr>
                            <td scope="col"><?= ($key + 1)?></td>
                            <td scope="col"><?= $value['TEN_NHANVIEN']?></td>
                            <td scope="col"><?= $value['TONG']?></td>
                            <td scope="col"><?= $value['KEHOACHTHANG']?></td>
                            <td scope="col"><?= $value['DALH']?></td>
                            <td scope="col"><?= $value['DAGIAHAN']?></td>
                            <td scope="col" style="color: red;"><b><?= $value['KEHOACHTHANG'] ? round($value['DAGIAHAN'] * 100/$value['KEHOACHTHANG'], 2): 100?> %</b></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                            <td scope="col"></td>
                            <td scope="col">TỔNG CỘNG</td>
                            <td scope="col"><?= $tongmuctieu?></td>
                            <td scope="col"><?= $tongmuctieuthang?></td>
                            <td scope="col"><?= $tongdalienhe?></td>
                            <td scope="col"><?= $tongdagiahan?></td>
                            <td scope="col" style="color: red;"><b><?= $tongmuctieuthang ? round($tongdagiahan * 100/$tongmuctieuthang, 2) : 100 ?> %</b></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>