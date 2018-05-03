<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\User;
use app\models\Nhanvien;
use app\models\AuthItem;
use app\models\AuthAssignment;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vai trò người dùng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-role">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="col-sm-6">
                <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(User::find()->all(), 'id', 'nhanvien.TEN_NHANVIEN'),
                    'options' => ['placeholder' => 'Chọn nhân viên' ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
                
            <div class="col-sm-6">
                <?= $form->field($model, 'item_name')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(AuthItem::find()->where(['type' => 1 ])->all(), 'name', 'name'),
                    'options' => ['placeholder' => 'Chọn  vai trò' ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
                
        </div>
        <div class="box-footer">
            <div class="text-center">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Thêm' : '<i class="fa fa-pencil-square-o"></i> Cập nhật', ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
        </div>
    </div>
            
    <?php ActiveForm::end(); ?>
</div>
