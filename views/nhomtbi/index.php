<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Nhomtbi;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NhomtbiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhóm thiết bị';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhomtbi-index">
    <div class="row">
        <?php if(Yii::$app->user->can('create-nhomtb')) { ?>
            <div class="col-sm-3 pull-right">
                <?php 
                    $addForm =ActiveForm::begin(['action' => Url::to(['nhomtbi/create'])]);
                    $nhomtbAdd = new Nhomtbi;
                ?>
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="col-sm-12">
                            <?= $addForm->field($nhomtbAdd, 'MA_NHOM')->textInput(['maxlength' => true]) ?>
                        </div>
                            
                        <div class="col-sm-12">
                            <?= $addForm->field($nhomtbAdd, 'TEN_NHOM')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="text-center">
                            <?= Html::submitButton('<i class="fa fa-plus"></i> Thêm nhóm', ['class' => 'btn btn-primary btn-flat']) ?>
                        </div>            
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        <?php } ?>
        <div class="<?= (Yii::$app->user->can('create-nhomtb')) ? 'col-sm-9' : 'col-sm-12' ?>">
            <div class="box box-primary">
                <div class="box-body">
                    <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'MA_NHOM',
                            'TEN_NHOM',

                            ['class' => 'yii\grid\ActionColumn',
                            'template' => (Yii::$app->user->can('edit-nhomtb')) ? '{view} {update} {delete}' : '{view}'],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
        
