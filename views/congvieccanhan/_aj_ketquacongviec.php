    <input type="hidden" name="ID_DOTBD" id="ID_DOTBD" value="<?php echo $condition['ID_DOTBD']?>">
    <input type="hidden" name="ID_THIETBI" id="ID_THIETBI" value="<?php echo $condition['ID_THIETBI']?>">
    <input type="hidden" name="MA_NOIDUNG" id="MA_NOIDUNG"value="<?php echo $condition['MA_NOIDUNG']?>">
    <input type="hidden" name="IS_DONE" id="IS_DONE" value="<?php echo $condition['IS_DONE']?>">
    <?php foreach($congviec as $key => $cv) :?>
        <div class="form-group">
            <label><?php echo $key;?></label>
            <?php if($cv['type'] == 'select') {?>
                <select id="<?php echo $key;?>" class="form-control" name="<?php echo $key;?>">
                    <?php foreach($cv['value'] as $v) :?>
                        <option value="<?php echo $v;?>"><?php echo $v;?></option>
                    <?php endforeach; ?>
                </select>
            <?php } else if($cv['type'] == 'input') {?>
                <input type="text" name="<?php echo $key;?>" class="form-control" id="<?php echo $key;?>">
            <?php } else if($cv['type'] == 'multiple_field') {?>
                <?php foreach($cv['fields'] as $keyField => $field) :?>
                    <br>
                    <label><?php echo $field['label'];?>:</label>
                    <input type="text" name="<?php echo $key . '[' . $keyField . ']'?>" class="form-control" id="<?php echo $keyField?>">
                <?php endforeach; ?>
                
            <?php }?>
        </div>
    <?php endforeach; ?>
