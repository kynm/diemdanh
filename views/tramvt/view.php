<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use app\models\Thietbitram;
use app\models\Thietbi;
use app\models\Tramvt;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Tramvt */

$this->title = $model->ID_TRAM;
$this->params['breadcrumbs'][] = ['label' => 'Tramvts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramvt-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            '<i class="glyphicon glyphicon-plus"></i> Thêm thiết bị', 
            '#', 
            [
                'class'=>'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#themNoiDung',
            ]
        ) ?>
    </p>
<h3><strong>Notice:</strong> Edit link Action column</h3>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'ID_LOAITB',
                'value' => 'iDLOAITB.TEN_THIETBI'
            ],
            [
                'attribute' => 'ID_TRAM',
                'value' => 'iDTRAM.MA_TRAM'
            ],
            'LANBAODUONGTRUOC',
            'LANBAODUONGTIEP',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

</div>
<div class="modal fade" id="themNoiDung" tabindex="-1" role="dialog" aria-labelledby="themNoiDungLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $modalForm = ActiveForm::begin();
            $tbiModel = new Thietbitram;
      ?>
      <div class="modal-body"> 
            <div class="col-sm-6 col-md-6">       
                <?= $modalForm->field($tbiModel, 'ID_LOAITB')->dropDownList(
                    ArrayHelper::map(Thietbi::find()->all(), 'ID_THIETBI', 'TEN_THIETBI'),
                    ['prompt' => 'Chọn loại thiết bị']
                ) ?>
            </div>

            <div class="col-sm-6 col-md-6">
                <?= $modalForm->field($tbiModel, 'ID_TRAM')->dropDownList(
                    ArrayHelper::map(Tramvt::find()->all(), 'ID_TRAM', 'MA_TRAM'),
                    ['prompt' => 'Chọn trạm']
                ) ?>
            </div>
            
            <div class="col-sm-12 col-md-12">
                <?= $modalForm->field($tbiModel, 'SERIAL_MAC')->textInput() ?>
            </div>
            
            <div class="row col-md-12" style="margin-bottom: 8px">
                <div class="col-sm-4 col-md-4">
                    <?= DatePicker::widget([
                        'model' => $tbiModel,
                        'attribute' => 'NGAYSX',
                        'name' => 'ngaysx', 
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Ngày sản xuất ...'],
                        'pluginOptions' => [

                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-4 col-md-4">
                        <?= DatePicker::widget([
                            'model' => $tbiModel,
                            'attribute' => 'NGAYSD',
                            'name' => 'ngaysd', 
                            'removeButton' => false,
                            'options' => ['placeholder' => 'Ngày đưa vào sử dụng ...'],
                            'pluginOptions' => [

                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true
                            ]
                        ]); ?>
                </div>
                <div class="col-sm-4 col-md-4">
                        <?= DatePicker::widget([
                            'model' => $tbiModel,
                            'attribute' => 'LANBAODUONGTRUOC',
                            'name' => 'ngaybd', 
                            'removeButton' => false,
                            'options' => ['placeholder' => 'Lần bảo dưỡng gần đây ...'],
                            'pluginOptions' => [

                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true
                            ]
                        ]); ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-12">
                <?= $modalForm->field($tbiModel, 'LANBD')->textInput() ?>
            </div>
      </div>
      <div class="modal-footer">
        <?= Html::a(
            '<i class="glyphicon glyphicon-plus"></i> Thêm', 
            '#', 
            [
                'class'=>'btn btn-primary',
                'id' => 'addBtn',
                'onclick' => '
                    var idloaitb = '.$tbiModel->ID_LOAITB.';
                    var idtram = $("#thietbitram-id_tram").val();
                    var serialNum = $("#thietbitram-serial_mac").val();
                    var ngaysx = $("#thietbitram-ngaysx").val();
                    var ngaysd = $("#thietbitram-ngaysd").val();
                    var ngaybd = $("#thietbitram-lanbaoduongtruoc").val();
                    var lanbd = $("#thietbitram-lanbd").val();

                    $.post("index.php?r=thietbitram/create-post&ID_LOAITB="+idloaitb+"&ID_TRAM="+idtram+"SERIAL_MAC="+serialNum+"&NGAYSX="+ngaysx+"&NGAYSD="+ngaysd+"&LANBAODUONGTRUOC="+ngaybd+"&LANBD="+lanbd+"");
                ',
            ]
        )?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>