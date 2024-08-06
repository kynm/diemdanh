<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'ĐẾM SỐ NGÀY TRONG TUẦN TRONG MỘT KHOẢNG THỜI GIAN';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
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
<div class="box-body table-responsive">
    </h2>
    <div class="col-lg-3 col-6">
        <table class="table table-bordered">
            <tbody>
                <tr class="bg-primary text-center">
                    <th class="text-center">Thứ</th>
                    <th class="text-center">Số ngày</th>
                    <th class="text-center"></th>
                </tr>
                <?php foreach ($result as $key => $value): ?>
                <tr class="text-center">
                    <td><?= dateofmonth()[$key]?></td>
                    <td><?= $value?></td>
                    <td><input type="checkbox" class="checkngay" value="<?= $value?>"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-lg-3 col-6">
        <h1><span id="priceSection" style="color:red">0</span></h1>
    </div>
</div>
<?php
$script = <<< JS
    (function() {
      let addonCheckboxes = document.querySelectorAll(".checkngay");
      
      function update()
      {
        let total = 0;
        
        for(let i = 0 ; i < addonCheckboxes.length ; ++i)
          if(addonCheckboxes[i].checked == true)
            total += parseInt(addonCheckboxes[i].value);
            
        document.getElementById("priceSection").innerHTML = "Result: " + total;
      }

      for(let i = 0 ; i < addonCheckboxes.length ; ++i)
        addonCheckboxes[i].addEventListener("change", update);
    })();
JS;
$this->registerJs($script);
?>