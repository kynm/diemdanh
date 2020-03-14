<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Baoduongtong;
use app\models\Tramvt;
use app\models\Daivt;
use app\models\Donvi;
use app\models\Nhomtbi;
use app\models\Thietbi;
use app\models\Nhanvien;
use app\models\ProfileBaoduong;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Dotbaoduong */

$this->title = 'Thêm đợt bảo dưỡng theo loại thiết bị';
$this->params['breadcrumbs'][] = ['label' => 'Các đợt bảo dưỡng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$animateIcon = ' <i class="fa fa-spinner fa-spin"></i>';
$this->registerJs('$("#searchBtn").children("i.fa-spin").hide();')
?>

<div class="dotbaoduong-create">
	<?php $form = ActiveForm::begin(); ?>

	<div class="box box-primary">
		<div class="box-body">
			<div class="col col-md-4">
				<div class="col-sm-12">
					<?= $form->field($model, 'ID_BDT')->dropDownList(ArrayHelper::map(Baoduongtong::find()->where(['TYPE' => 0])->all(), 'ID_BDT', 'MO_TA')) ?>
				</div>
				<div class="col-sm-12">
					<a class="modalButton" href="<?=Url::to(['baoduongtong/create'])?>">Thêm mới</a>
				</div>
				<div class="col-sm-6" style="margin-top: 15px">
					<label class="control-label">Ngày bắt đầu dự kiến</label>
					<?= DatePicker::widget([
						'model' => $model,
						'attribute' => 'NGAY_DUKIEN',
						'name' => 'ngaybd', 
						'removeButton' => false,
						'options' => ['required' => true],
						'pluginOptions' => [
							'placeholder' => 'Dự kiến ...', 
							'format' => 'yyyy-mm-dd',
							'todayHighlight' => true
						]
					]); ?>
				</div>

				<div class="col-sm-6" style="margin-top: 15px">
					<label class="control-label">Ngày kết thúc dự kiến</label>
					<?= DatePicker::widget([
						'model' => $model,
						'attribute' => 'NGAY_KT_DUKIEN',
						'name' => 'ngaykt', 
						'removeButton' => false,
						'options' => ['placeholder' => 'Dự kiến ...', 'required' => true, 'allowClear' => true],
						'pluginOptions' => [

							'format' => 'yyyy-mm-dd',
							'todayHighlight' => true
						]
					]); ?>
				</div>
			</div>

			<div class="col col-md-8">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label">Loại bảo dưỡng</label>
						<?= Select2::widget([
							'name' => 'profile_baoduong',
							'id' => 'profile_baoduong',
							'value' => '',
							'data' => ArrayHelper::map(ProfileBaoduong::find()->all(), 'ID', 'TEN_PROFILE'),
							'theme' => Select2::THEME_BOOTSTRAP,
							'options' => ['placeholder' => 'Chọn loại bảo dưỡng...']
						]); ?>
					</div>

					<div class="col-sm-4">
						<?= $form->field($model, 'donvi')->dropDownList($listDonvi, [
							'prompt' => "Chọn đơn vị / Tất cả",
							'onchange' => '
							donvi = $("#dotbaoduong-donvi").val();
							dai = "";
							$.post("'.Yii::$app->homeUrl.'tramvt/search?donvi="+donvi+"&dai="+dai, function( data ) {
								$("#dotbaoduong-id_tram").html( data );
							});
							$.post("'.Yii::$app->homeUrl.'nhanvien/list?id="+$(this).val(), function( data ) {
								$("#dotbaoduong-dai").html( data );
							});'
						]); ?>
					</div>
					<div class="col-sm-4">
						<?= $form->field($model, 'dai')->dropDownList([], [
							'prompt' => 'Chọn đài viễn thông',
							'onchange' => '
							donvi = $("#dotbaoduong-donvi").val();
							dai = $(this).val();
							$.post("'.Yii::$app->homeUrl.'tramvt/search?donvi="+donvi+"&dai="+dai, function( data ) {
								$("#dotbaoduong-id_tram").html( data );
							});'
						]); ?> 
					</div>
				</div>

				<?= $form->field($model, 'ID_TRAM')->widget(Select2::classname(), [
                    'data' => $listTram,
					// 'data' => [],
					'theme' => Select2::THEME_BOOTSTRAP,
					'pluginOptions' => [
						'placeholder' => 'Chọn trạm',
						'allowClear' => true,
						'multiple' => true
					],
				]); ?>

			</div>
		</div>
		<div class="box-footer">
			<div class="text-center">
				<?= Html::a(
					'<i class="fa fa-remove"></i> Hủy ', 
					['#'],
					[
						'class' => 'btn btn-danger btn-flat',
						'style' => 'width: 74px'
					]
				)?>

				<?= Html::submitButton(
					'<i class="fa fa-save"></i> Lưu ', 
					[
						'class' => 'btn btn-primary btn-flat',
						'style' => 'width: 74px'
					]
				)?>
			</div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>

<?php 
Modal::begin([
	'header' => '<h3>Thêm bảo dưỡng tổng<h3>',
	'id' => 'modal',
	'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();

$script = <<< JS
	$(function(){
	    // changed id to class
	    $('.modalButton').click(function (){
	        $.get($(this).attr('href'), function(data) {
	        	form = $(data).find('#baoduongtong-create');
	        	$('#modal').modal('show').find('#modalContent').html(form);
	       });
	       return false;
	    });
	}); 
JS;
$this->registerJs($script);
?>