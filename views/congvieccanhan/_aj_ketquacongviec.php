<div class="form-group">
    <label>Kết quả</label>
    <input type="hidden" name="ID_THIETBI" id="ID_THIETBI" value="<?php echo $condition['ID_THIETBI']?>">
    <input type="hidden" name="MA_NOIDUNG" id="MA_NOIDUNG"value="<?php echo $condition['MA_NOIDUNG']?>">
    <input type="hidden" name="IS_DONE" id="IS_DONE" value="<?php echo $condition['IS_DONE']?>">
    <select id="KETQUABAODUONG" class="form-control" id="KETQUABAODUONG">
        <option value="dat">Đạt</option>
        <option value="khong_dat">Không đạt</option>
    </select>
</div>
<div class="form-group">
    <label>Kiến nghị</label>
    <input type="text" name="KIENNGHI" class="form-control" id="KIENNGHI">
</div>