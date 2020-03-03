<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<input type="hidden" name="url" id="url" value="<?= Url::to(['congvieccanhan/hoanthanh']) ?>">
<input type="hidden" name="urlxacnhan" id="urlxacnhan" value="<?= Url::to(['congvieccanhan/xacnhantatca']) ?>">
<input type="hidden" name="urlketthuc" id="urlketthuc" value="<?= Url::to(['dotbaoduongcanhan/hoanthanh']) ?>">
<input type="hidden" name="ID_DOTBD" value="<?= Html::encode("{$data['THONGTIN_DBD']['ID_DOTBD']}") ?>" id="ID_DOTBD">
<h1><?= Html::encode("{$data['THONGTIN_DBD']['TRAMVT']->TEN_TRAM}  --  {$data['THONGTIN_DBD']['TRAMVT']->DIADIEM}")?></h1>
<h1>Danh sách công việc</h1>
<h3><?= Html::encode("{$data['THONGTIN_DBD']['MA_DOTBD']} -  {$data['THONGTIN_DBD']['TRANGTHAI']} -  {$data['THONGTIN_DBD']['NGAY_BD']}  -   {$data['THONGTIN_DBD']['NGAY_KT']}")?></h3>
<?php foreach ($data['DS_CONGVIEC'] as $loaitb => $dscongviec): ?>
<div class="box box-primary">
<div class="box-header">
  <h3 class="box-title"><?= Html::encode("{$loaitb}") ?></h3>
</div>
<div class="box-body">
  <ul class="todo-list">
    <?php foreach ($dscongviec as $congviec): ?>
        <li>
            <input onclick="xulycongviec(<?= Html::encode("{$congviec['ID_DOTBD']}") ?>, <?= Html::encode("{$congviec['ID_THIETBI']}") ?>, '<?= Html::encode("{$congviec['NOIDUNG']['MA_NOIDUNG']}") ?>')" type="checkbox" <?php echo $congviec['TRANGTHAI'] ? 'checked' : ''; ?> >
            <span class="text"><?= Html::encode("{$congviec['NOIDUNG']['NOIDUNG']} ({$congviec['NOIDUNG']['MA_NOIDUNG']})") ?></span>
            <span class="text"><?= Html::encode("{$congviec['ID_DOTBD']} {$congviec['ID_THIETBI']}") ?></span>
            <small class="label label-danger"><i class="fa fa-clock-o"></i> </small>
        </li>
     <?php endforeach; ?>
     <li>
           
     </li>
  </ul>
</div>
</div>
<?php endforeach; ?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Hình ảnh đợt bảo dưỡng</h3>
    </div>
    <div class="box-body">
        <ul class="todo-list">
            <input type="file" id="img1" name="img1" accept="image/*">
            <input type="file" id="img2" name="img2" accept="image/*">
            <input type="file" id="img3" name="img3" accept="image/*">
        </ul>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <ul class="todo-list">
            <button class="btn btn-default btn-primary" id="xacnhantatca">Xác nhận tổ trưởng</button>
            <button class="btn btn-default btn-success" id="ketthucdotbaoduong">Kết thúc đợt bảo dưỡng</button>
        </ul>
    </div>
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Kết quả</label>
            <input type="hidden" name="ID_THIETBI" id="ID_THIETBI">
            <input type="hidden" name="MA_NOIDUNG" id="MA_NOIDUNG">
            <select id="KETQUABAODUONG" class="form-control" id="KETQUABAODUONG">
                <option value="1">Đạt</option>
                <option value="0">Không đạt</option>
            </select>
        </div>
        <div class="form-group">
            <label>Kiến nghị</label>
            <input type="text" name="KIENNGHI" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="hoanthanhconviec" data-dotbaoduong="">Hoàn thành</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    function xulycongviec(ID_DOTBD, ID_THIETBI, MA_NOIDUNG) {
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: 'post',
            data: {
                ID_DOTBD: ID_DOTBD,
                ID_THIETBI: ID_THIETBI,
                MA_NOIDUNG: MA_NOIDUNG
            },
            success:function(data) {
                if (!data.error) {
                    Swal.fire('Đã cập nhật');
                }
                // $('#myModal').modal('hide');
            }
        });
        return 1;
        $("#ID_DOTBD").val(ID_DOTBD);
        $("#ID_THIETBI").val(ID_THIETBI);
        $("#MA_NOIDUNG").val(MA_NOIDUNG);
        console.log(ID_DOTBD + '-' + ID_THIETBI + '-' + MA_NOIDUNG);
        $('#myModal').modal('show');
    }
</script>
<?php
$script = <<< JS
    $( document ).ready(function() {
        $("#xacnhantatca").on( "click", function() {
          var ID_DOTBD = $("#ID_DOTBD").val();
          var urlxacnhan = $("#urlxacnhan").val();
          var KETQUABAODUONG = $("#KETQUABAODUONG").val();
            $.ajax({
                url: urlxacnhan ,
                method: 'post',
                data: {
                    ID_DOTBD: ID_DOTBD,
                    KETQUA: 1,
                },
                success:function(data) {
                    console.log(data);
                }
            });
        });

        $("#ketthucdotbaoduong").on( "click", function() {
          var ID_DOTBD = $("#ID_DOTBD").val();
          var urlketthuc = $("#urlketthuc").val();
          var KETQUABAODUONG = $("#KETQUABAODUONG").val();
            $.ajax({
                url: urlketthuc ,
                method: 'post',
                data: {
                    ID_DOTBD: ID_DOTBD,
                },
                success:function(data) {
                    console.log(data);
                }
            });
        });

        $("#hoanthanhconviec").on( "click", function() {
          var ID_DOTBD = $("#ID_DOTBD").val();
          var ID_THIETBI = $("#ID_THIETBI").val();
          var MA_NOIDUNG = $("#MA_NOIDUNG").val();
          var url = $("#url").val();
          var KETQUABAODUONG = $("#KETQUABAODUONG").val();
          console.log(ID_DOTBD + '-' + ID_THIETBI + '-' + KETQUABAODUONG + '-' + MA_NOIDUNG);
            $.ajax({
                url: url,
                method: 'post',
                data: {
                    ID_DOTBD: ID_DOTBD,
                    ID_THIETBI: ID_THIETBI,
                    MA_NOIDUNG: MA_NOIDUNG
                },
                success:function(data) {
                    $('#myModal').modal('hide');
                }
            });
        });
    });
JS;
$this->registerJs($script);
?>

