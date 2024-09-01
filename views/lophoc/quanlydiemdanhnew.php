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

$this->title = $diemdanh->lop->TEN_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quanlydiemdanh-view">
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
<?= $this->render('/partial/_header_diemdanh', ['model' => $diemdanh->lop,]) ?>
<div class="">
        <table class="table table-bordered">
            <tbody>
                <tr class="bg-primary text-center">
                    <th class="text-center">HỌ TÊN</th>
                    <?php foreach ($header as $key => $value):?>
                        <th class="text-center">
                            <?= $value['NGAY']?><br>
                            <?= Html::a('<i class="fa fa-print"></i> CHI TIẾT', '/quanlydiemdanh/indiemdanhngay?id=' . $value['ID'], ['class' => 'btn btn-success', 'target' => '_blank'])?><br>
                            <?=Yii::$app->user->can('quanlytruonghoc') ? '<span class="btn btn-danger xoadiemdanh" data-id="' . $value['ID'] . '" style="color: white;">Xóa</span>' : ''?>
                        </th>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($rows as $a => $row):
                    ?>
                    <tr class="">
                        <td><?= $row['HO_TEN']?></td>
                        <?php foreach ($header as $b => $h):
                        ?>
                            <td class="text-center">
                                <?= (isset($row['STATUS'][$b]['STATUS']) && $row['STATUS'][$b]['STATUS']) ? 'X' : 'NGHỈ'?><br/>
                                <?= isset($row['NHAN_XET'][$b]['NHAN_XET']) ? nl2br($row['NHAN_XET'][$b]['NHAN_XET']) : null?><br/>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
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