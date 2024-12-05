<?php
$this->title = 'BÁO CÁO CHẤM ĐIỂM';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('/lophoc/_detail', ['model' => $lophoc,]) ?>
</div>
<?= $this->render('/partial/_chamdiem', ['model' => $lophoc]) ?>
<div class="box-body table-responsive">
    </h2>
    <div class="col-lg-12 col-12">
        <table class="table table-bordered" style="font-size: 20px">
            <tbody>
                <tr class="bg-primary text-center">
                    <th class="text-center">HỌ TÊN</th>
                    <?php foreach ($header as $key => $value):?>
                        <th class="text-center"><?= $value?></th>
                    <?php endforeach; ?>
                    <th class="text-center">TỔNG</th>
                </tr>
                <?php foreach ($rows as $a => $row):
                    $tong = 0;
                ?>
                    <tr class="">
                        <td style="border: 1px solid;"><?= $row['HO_TEN']?></td>
                        <?php foreach ($header as $b => $h):
                            $tong += isset($row['DIEM'][$b]['DIEM']) ? $row['DIEM'][$b]['DIEM'] : 0; 
                        ?>
                            <td class="text-center" style="border: 1px solid;"><?= isset($row['DIEM'][$b]['DIEM']) ? $row['DIEM'][$b]['DIEM'] : null?></td>
                        <?php endforeach; ?>
                        <td style="border: 1px solid;"><?= $tong?></td>
                    </tr>
                <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
