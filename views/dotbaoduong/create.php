<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Nhomtbi;
use kartik\select2\Select2;
use kartik\date\DatePicker;

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
	                <?= $form->field($model, 'MA_DOTBD')->textInput(['maxlength' => true]) ?>
	            </div>
	            <div class="col-sm-12">
	            	<?= Html::label('Mô tả', 'MO_TA') ?>
	                <?= Html::textArea('MO_TA', '', ['class' => 'form-control', 'placeholder' => 'Nhập mô tả']) ?>
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
		            	<label class="control-label">Nhóm thiết bị</label>
		                <?= Select2::widget([
						    'name' => 'nhomtbi',
						    'id' => 'nhomtbi',
						    'value' => '',
						    'data' => ArrayHelper::map(Nhomtbi::find()->all(), 'ID_NHOM', 'TEN_NHOM'),
						    'theme' => Select2::THEME_BOOTSTRAP,
						    'options' => ['multiple' => true, 'placeholder' => 'Chọn nhóm thiết bị...'],
						    'pluginOptions' => [
		                        'allowClear' => true
		                    ],
						    'pluginEvents' => [
						    	'select2:select' => 'function() {
						       		$.post("'.Yii::$app->homeUrl.'thietbi/list?id="+$(this).val(), function( data ) {
	                                    $("#thietbi").html( data );
	                                    //$("#thietbi").append(JSON.stringify(data));
	                                });
						       }',
						    ]
						]); ?>
		            </div>

		    		<div class="col-sm-4">
		                <?= $form->field($model, 'donvi')->dropDownList($listDonvi, 
	                        [
	                            'prompt' => "Chọn đơn vị / Tất cả",
	                            'onchange' => '
	                                $.post("'.Yii::$app->homeUrl.'nhanvien/list?id="+$(this).val(), function( data ) {
	                                    $("#dotbaoduong-dai").html( data );
	                                });'
	                        ]); ?>
		            </div>
		    		<div class="col-sm-4">
		                <?= $form->field($model, 'dai')->dropDownList([], ['prompt' => 'Chọn đài viễn thông' ]); ?> 
		            </div>
	    		</div>
	    		<div class="row">
		    		<div class="col-sm-10">
		            	<label class="control-label">Thiết bị bảo dưỡng</label>
		                <?= Select2::widget([
						    'name' => 'thietbi',
						    'id' => 'thietbi',
						    'value' => '',
						    'theme' => Select2::THEME_BOOTSTRAP,
						    // 'data' => ArrayHelper::map(Thietbi::find()->all(), 'ID_THIETBI', 'TEN_THIETBI'),
						    'options' => ['multiple' => true, 'placeholder' => 'Chọn thiết bị/Tất cả thiết bị trong nhóm...'],
						    'pluginOptions' => [
		                        'allowClear' => true
		                    ]
						]); ?>
		            </div>	    			
		            <div class="col-sm-2" style="margin-top:25px">
		            	<?= Html::a(
		                    'Tìm kiếm ' .$animateIcon,
		                    ['taodotbaoduong#'],
		                    [
		                        'class'=>'btn btn-primary btn-flat btn-block',
		                        'id' => 'searchBtn',
		                        'onclick' => '
		                        	donvi = $("#dotbaoduong-donvi").val();
		                        	dai = $("#dotbaoduong-dai").val();
		                        	thietbi = $("#thietbi").val();
									if (thietbi.length == 0) {
										var x = document.getElementById("thietbi");
										for (i = 0; i<x.options.length; i++) {
											thietbi.push(x.options[i].value);
										}
									}
	                        		$("#searchBtn").children("i.fa-spin").show();
	                        		$.post("'.Yii::$app->homeUrl.'thietbitram/search?donvi="+donvi+"&dai="+dai+"&thietbi="+thietbi, function(data) {
	                        			$("#dotbaoduong-id_tram").html(data);
	                        		}).always(function () {
							            $("#searchBtn").children("i.fa-spin").hide();
							        });
		                        	
		                        '
		                    ]) ?>
		            </div>
	    		</div>
	    		
    			<?= $form->field($model, 'ID_TRAM')->widget(Select2::classname(), [
                    // 'data' => $listTram,
                    'data' => [],
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
$script = <<< JS
    $(document).ready(function() {
        $("form").on("submit",function(eve){
            
            thietbi = $("#thietbi").val();
			if (thietbi.length == 0) {
            	$("#thietbi").find("option").prop("selected", true);
			}
            return true;
        })
    })
JS;
$this->registerJs($script);
?>