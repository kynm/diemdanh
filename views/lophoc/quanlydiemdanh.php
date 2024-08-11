<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Hocsinh;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $diemdanh->lop->MA_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('_detail', ['model' => $diemdanh->lop,]) ?>
</div>
<?php if (Yii::$app->user->can('diemdanhlophoc') && $diemdanh->lop->STATUS == 1):?>
<?php if (!Yii::$app->user->identity->nhanvien->iDDONVI->DIEMDANHTHUCONG):?>
    <div class="daivt-view">
        <?= $this->render('_form_diemdanh', ['model' => $diemdanh, 'id' => $diemdanh->ID_LOP,]) ?>
    </div>
<?php else: ?>
    <?= Html::a('THÊM ĐIỂM DANH', ['/lophoc/themdiemdanhthucong', 'id' => $diemdanh->ID_LOP], ['class' => 'btn btn-primary btn-flat'])?>
<?php endif; ?>
<?php else: ?>
<?php endif; ?>
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
<div class="box box-primary">
    <ul class="timeline timeline-inverse">
        <?php
            foreach ($result as $key => $value):
        ?>
        <li class="time-label">
            <span class="bg-green">
                <?= Yii::$app->formatter->asDate($value->NGAY_DIEMDANH, 'd-M-Y');?>
            </span>
        </li>
        <li>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?= dateofmonth()[date_format(date_create($value->NGAY_DIEMDANH), 'w')]?></span>
                <h3 class="timeline-header"><?= $value->lop->STATUS ? Html::a($value->TIEUDE, '/lophoc/capnhatdiemdanh?diemdanhid=' . $value->ID) : $value->TIEUDE?></h3>
                <div class="timeline-body">
                    TỔNG SỐ : <?= $value->getDschitietdiemdanh()->count()?> (HỌC SINH)<br/>
                    ĐI HỌC: <?= $value->getDschitietdiemdanh()->andWhere(['STATUS' => 1])->count()?> (HỌC SINH)
                </div>
            </div>
        </li>
        <?php if ($value->NOIDUNG):?>
            <li>
                <i class="fa fa-user bg-aqua"></i>
                <div class="timeline-item">
                    <?= nl2br($value->NOIDUNG)?>
                </div>
            </li>
        <?php endif; ?>
        <li>
            <i class="fa fa-comments bg-yellow"></i>
            <div class="timeline-item">
                <h3 class="timeline-header">DANH SÁCH HỌC SINH VẮNG</h3>
                <div class="timeline-body">
                <?php
                        $idhocsinh = ArrayHelper::map($value->getDschitietdiemdanh()->andWhere(['STATUS' => 0])->all(), 'ID_HOCSINH', 'ID_HOCSINH');
                        $dshocsinhvang = ArrayHelper::map(Hocsinh::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['in', 'ID', $idhocsinh])->all(), 'ID', 'HO_TEN');
                    ?>
                    <?= nl2br(implode(',', $dshocsinhvang))?>
                </div>
            </div>
        </li>
        <li>
            <i class="fa fa-comments bg-yellow"></i>
            <div class="timeline-item">
                <h3 class="timeline-header">GHI CHÚ</h3>
                <div class="timeline-body">
                <?= nl2br($value->ghichu)?>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <br>
    <br>
    <br>
</div>
