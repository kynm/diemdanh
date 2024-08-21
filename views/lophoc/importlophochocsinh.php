<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */
$this->title = 'Import học sinh';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramvt-update">
    <a href="https://docs.google.com/spreadsheets/d/1gu9cM8g9VJ_gJwQ1CcqRp-IzWxCjC501/edit?gid=1993523321#gid=1993523321" class="btn btn-primary btn-flat" target="_blank">MẪU IMPORT </a>
    <div class="import-dien-form">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
        ]); ?>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="col-md-2 col-xs-2">
                        <?= $form->field($model, 'fileupload')->fileInput(['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);?>
                    </div>
                </div>
                <div class="col-md-2 col-xs-2">
                    <?= Html::submitButton(
                        '<i class="fa fa-search"></i> Import', 
                        [
                            'class'=>'btn btn-primary btn-flat',
                            'id' => 'searchBtn',
                            
                        ])
                    ?>
                </div>
            </div>     
            
            <?php ActiveForm::end(); ?>
    </div>
</div>