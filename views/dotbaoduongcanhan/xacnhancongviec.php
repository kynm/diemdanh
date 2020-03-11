<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\Images;
?>
<input type="hidden" name="url" id="url" value="<?= Url::to(['congvieccanhan/hoanthanh']) ?>">
<input type="hidden" name="urlxacnhan" id="urlxacnhan" value="<?= Url::to(['congvieccanhan/xacnhantatca']) ?>">
<input type="hidden" name="urlketthuc" id="urlketthuc" value="<?= Url::to(['dotbaoduongcanhan/hoanthanh']) ?>">
<input type="hidden" name="urlnhanvienhoanthanh" id="urlnhanvienhoanthanh" value="<?= Url::to(['dotbaoduongcanhan/nhanvienhoanthanh']) ?>">
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
            <span class="text"><?= Html::encode("{$congviec['NOIDUNG']['NOIDUNG']} ({$congviec['NOIDUNG']['MA_NOIDUNG']})") ?></span>
            <span class="text"><?= Html::encode("{$congviec['ID_DOTBD']} {$congviec['ID_THIETBI']}") ?></span>
            <small class="label label-success"><i class="fa fa-thumbs-o-up"></i> </small>
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

<?php
$script = <<< JS
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
JS;
$this->registerJs($script);
?>

