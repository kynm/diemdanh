<table class="table">
    <tr style="border: none;">
        <td colspan="2" style="text-align: center;border: none;">VNPT HÀ NAM</td>
        <td colspan="4"style="text-align: center;border: none;"></td>
        <td colspan="2" style="text-align: center;border: none;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</td>
    </tr>
    <tr style="border: none;">
        <td colspan="2" style="text-align: center;border: none;">TRUNG TÂM ĐHTT</td>
        <td colspan="3" style="text-align: center;border: none;width: 50%"></td>
        <td colspan="3" style="text-align: center;border: none;">Độc lập - Tự do - Hạnh phúc</td>
    </tr>
    <tr style="border: none;">
        <td colspan="2" style="text-align: center;border: none;"></td>
        <td colspan="3"style="text-align: center;border: none;width: 50%"></td>
        <td colspan="3" style="text-align: center;border: none;font-style: italic;">Phủ Lý, ngày <?php echo date('d')?> tháng <?php echo date('m')?> năm <?php echo date('Y')?></td>
    </tr>
    <tr style="border: none;">
        <td colspan="8" style="text-align: center;border: none;font-weight: bold;"><h3>BÁO CÁO TỔNG HỢP NHIÊN LIỆU CÁC ĐÀI TRẠM</h3></td>
    </tr>
        <tr style="border: none;">
        <td colspan="8" style="text-align: center;border: none;"><span style="margin-right: 100px"> Tháng:  <?php echo $inputs['THANG'] . '/' . $inputs['NAM']?> </span>    Đơn vị:<?php echo $donvi->TEN_DONVI ?? 'Toàn tỉnh';?>  </td>
    </tr>
</table>
<?= $this->render('_table_data', [
    'data' => $data,
    'dongiamayno' => $dongiamayno,
]) ?>
<table class="table">
    <tr style="border: none;height: 20px;">
        <td colspan="2" style="text-align: left;border: none;font-weight: bold;">Nơi gửi</td>
        <td colspan="4"style="text-align: center;border: none;font-weight: bold;width: 50%;">Người lập biểu</td>
        <td colspan="2" style="text-align: center;border: none;font-weight: bold;;">TRUNG TÂM ĐIỀU HÀNH THÔNG TIN</td>
    </tr>
    <tr>
        <td colspan="2" style="border: none">
            Nơi gửi
            <br/>KTTKTC (Thực hiện)
            <br/>Lưu: TTĐHTT
        </td>
        <td colspan="4" style="border: none"></td>
        <td colspan="2" style="border: none"></td>
    </tr>
    <tr>
    </tr>
    <tr style="border: none;">
        <td colspan="2" style="text-align: left;border: none;"></td>
        <td colspan="4"style="text-align: center;border: none;width: 50%;"><?php echo Yii::$app->user->identity->nhanvien->TEN_NHANVIEN;?></td>
        <td colspan="2" style="text-align: center;border: none;"></td>
    </tr>
</table>