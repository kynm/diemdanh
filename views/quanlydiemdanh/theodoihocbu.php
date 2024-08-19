<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use app\models\Hocsinh;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'DANH SÁCH HỌC SINH CHƯA HỌC BÙ';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý điểm danh', 'url' => ['quanlydiemdanh/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quanlydiemdanh-index">
    <?= $this->render('/partial/_header_quanlydiemdanh', []) ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'ID_LOP',
                                'value' => 'diemdanh.lop.TEN_LOP',
                                'contentOptions' => ['style' => 'width:8%; white-space: normal;word-break: break-word;'],
                                'filter'=> $dslop,
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                                'attribute' => 'THU',
                                'value'  => function($model) {
                                    return dateofmonth()[date_format(date_create($model->diemdanh->NGAY_DIEMDANH), 'w')];
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'ID_HOCSINH',
                                'value'  => 'hocsinh.HO_TEN',
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'NGAY_DIEMDANH',
                                'value'  => function($model) {
                                    return  Yii::$app->formatter->asDatetime($model->diemdanh->NGAY_DIEMDANH, 'php:d/m/Y');
                                },
                                'format' => 'raw',
                            ],
                            'NGAY_DIEMDANH',
                            [
                                'attribute' => 'NHAN_XET',
                                'contentOptions' => ['style' => 'width:25%; white-space: normal;word-break: break-word;'],
                                'value'  => function($model) {
                                    return nl2br($model->NHAN_XET);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'HANHDONG',
                                'value'  => function($model) {
                                    return Yii::$app->user->can('quanlytruonghoc') ? '<span class="btn btn-danger btn-default text-white xacnhanhocbu" data-chitietid="' . $model->ID . '" style="color: white;">Xác nhận học bù</span>' : '';
                                },
                                'format' => 'raw',
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $(document).on('click', '.xacnhanhocbu', function() {
    Swal.fire({
        title: 'Bạn có chắc chắn học sinh đã được học bù không?',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Có!',
        cancelButtonText: "Không!"
    }).then((result) => {
    if (result['isConfirmed']) {
        var chitietid = $(this).data('chitietid');
        $.ajax({
            url: '/quanlydiemdanh/xacnhanhocbu',
            method: 'post',
            data: {
                chitietid: chitietid,
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