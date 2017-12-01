<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Dotbaoduong;
use app\models\Nhanvien;
use app\models\Noidungbaotri;
use app\models\Thietbitram;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Kehoachbdtb */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kehoachbdtb-form">

    <?php
		$form = ActiveForm::begin();
		echo Form::widget([
		    'model' => $model,
		    'form' => $form,
		    'attributes' => [
		        'ID_DOTBD' => [
		            'type' => TabularForm::INPUT_DROPDOWN_LIST, 
		            'items'=>ArrayHelper::map(Dotbaoduong::find()->all(), 'ID_DOTBD', 'MA_DOTBD')
		        ],
		        'ID_THIETBI' => [
		            'type' => TabularForm::INPUT_DROPDOWN_LIST, 
		            'items'=>ArrayHelper::map(Thietbitram::find()->all(), 'ID_THIETBI', 'iDLOAITB.TEN_THIETBI')
		        ],
		        'MA_NOIDUNG' => [
		            'type' => TabularForm::INPUT_DROPDOWN_LIST, 
		            'items'=>ArrayHelper::map(Noidungbaotri::find()->all(), 'MA_NOIDUNG', 'NOIDUNG')
		        ],
		        'ID_NHANVIEN' => [
		            'type' => TabularForm::INPUT_DROPDOWN_LIST, 
		            'items'=>ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN')
		        ],
		    ],
		]);
		echo '<div class="text-right">' . 
		     	Html::a(
                    '<i class="glyphicon glyphicon-plus"></i> Add New', 
                    '#', 
                    ['class'=>'btn btn-success']
                ) . '&nbsp;' . 
                Html::a(
                    '<i class="glyphicon glyphicon-remove"></i> Delete', 
                    '#', 
                    ['class'=>'btn btn-danger']
                ) . '&nbsp;' .
                Html::submitButton(
                    '<i class="glyphicon glyphicon-floppy-disk"></i> Submit', 
                    ['class'=>'btn btn-primary']
                ).
		     '<div>';
		ActiveForm::end();
    ?>

</div>
