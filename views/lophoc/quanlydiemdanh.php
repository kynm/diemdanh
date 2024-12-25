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

$this->title = $diemdanh->lop->TEN_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?php if (Yii::$app->user->can('quanlyhocsinh')):?>
        <?= Html::a('<i class="fa fa-pencil-square-o"></i> Quản lý học sinh', ['quanlyhocsinh', 'id' => $model->ID_LOP], ['class' => 'btn btn-primary btn-flat']) ?>
    <?php endif; ?>
    <?= (Yii::$app->user->can('diemdanhlophoc')) ? Html::a('Kiểm tra', ['/chamdiem/chamdiemlophoc', 'idlophoc' => $model->ID_LOP], ['class' => 'btn btn-success btn-flat']) : ''?>
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
<?= $this->render('/partial/_header_diemdanh', ['model' => $diemdanh->lop,]) ?>
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
                <span class="time"><i class="fa fa-clock-o"></i> <?= dateofmonth()[date_format(date_create($value->NGAY_DIEMDANH), 'w')]?></span> - <?= Yii::$app->formatter->asDate($value->NGAY_DIEMDANH, 'd-M-Y');?>
            </span>
        </li>
        <li>
            <div class="timeline-item">
                
                <?=Yii::$app->user->can('quanlytruonghoc') ? '<span class="btn btn-danger pull-right xoadiemdanh" data-id="' . $value->ID . '" style="color: white;">Xóa</span>' : ''?>
                <?= Html::a('<i class="fa fa-print"></i> CHI TIẾT', '/quanlydiemdanh/indiemdanhngay?id=' . $value->ID, ['class' => 'pull-right btn btn-success', 'target' => '_blank'])?>
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
<?php
$script = <<< JS
    $(document).on('click', '.xoadiemdanh', function() {
    Swal.fire({
        title: 'Dữ liệu sẽ bị xóa vĩnh viễn, không thể khôi phục lại.Bạn có chắc chắc muốn xóa lượt điểm danh không?',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Xóa ngay!',
        cancelButtonText: "Không!"
    }).then((result) => {
    if (result['isConfirmed']) {
        var id = $(this).data('id');
        $.ajax({
            url: '/quanlydiemdanh/xoadiemdanh',
            method: 'post',
            data: {
                id: id,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    Swal.fire('Xác nhận thành công');
                    setTimeout(() => {
                        window.location.reload(true);
                      }, 1000);
                } else {
                    Swal.fire(data.message);
                }
            }
        });
    }
    });
});
JS;
$this->registerJs($script);
?>