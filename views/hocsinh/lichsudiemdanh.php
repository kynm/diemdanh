<?php
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

$this->title = $model->HO_TEN;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hocsinh-view">

    <div class="box box-primary">
        <div class="box-body">
            
            <div class="box-body table-responsive">

            </div>
        </div>
    </div>
</div>
<div class="row">
<div class="col-md-3">
    <?= $this->render('_detail', ['model' => $model,]) ?>
</div>
<div class="col-md-9">
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
    <?= $this->render('/partial/_header_hocsinh', ['model' => $model,]) ?>
</ul>
<div class="tab-content">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
        ]); ?>
        <div class="col-sm-3">
            <label class="control-label">Từ ngày</label>
            <?=
             DatePicker::widget([
                'attribute' => 'TU_NGAY',
                'name' => 'TU_NGAY',
                'value' => $params['TU_NGAY'] ?? null,
                'removeButton' => false,
                'options' => ['required' => true],
                'pluginOptions' => [
                    'placeholder' => 'TỪ NGÀY', 
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ],
                'pluginEvents' => ['changeDate' => "function(e){
                   $(e.target).closest('form').submit();
                }"],
            ]); ?>
        </div>

        <div class="col-sm-3">
            <label class="control-label">Đến ngày</label>
            <?= DatePicker::widget([
                'attribute' => 'DEN_NGAY',
                'name' => 'DEN_NGAY', 
                'value' => $params['DEN_NGAY'] ?? null,
                'removeButton' => false,
                'options' => ['placeholder' => 'ĐẾN NGÀY', 'required' => true, 'allowClear' => true],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ],
                'pluginEvents' => ['changeDate' => "function(e){
                   $(e.target).closest('form').submit();
                }"],
            ]); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="tab-pane active" id="timeline">
        <ul class="timeline timeline-inverse">
            <?php
                foreach ($result as $key => $value):
            ?>
            <li class="time-label">
                <span class="bg-<?= $value->STATUS ? 'green' : 'red'?>">
                    <?= $value->diemdanh->NGAY_DIEMDANH?>
                </span>
            </li>
            <li>
                <i class="<?= $value->STATUS ? 'fa fa-check bg-green' : 'fa  fa-ban bg-red'?>"></i>
                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                    <h3 class="timeline-header"><?= $value->diemdanh->TIEUDE?></h3>
                    <div class="timeline-body">
                        <?= nl2br($value->NHAN_XET)?>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
</div>
</div>
</div>