<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\lophocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QUẢN LÝ HỌC PHÍ THU TRƯỚC';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lophoc-index">
    <p>
        <?= (Yii::$app->user->can('quanlytruonghoc')) ? Html::a('<i class="fa fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary btn-flat']) :'' ?>
    </p>

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
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;word-break: break-word;'],
                                'value' => 'lop.TEN_LOP',
                                'filter'=> $dslop,
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                                'attribute' => 'ID_HOCSINH',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    $hoten = $model->hocsinh ? $model->hocsinh->HO_TEN : 'Không tìm thấy học sinh';
                                    return $model->STATUS == 1 ? Html::a($hoten, ['view', 'id' => $model->ID]) : $hoten;
                                },
                                'format' => 'raw',
                            ],
                            'created_at',
                            'SOTIEN',
                            'SO_BH',
                            'TIENKHAC',
                            'TONGTIEN',
                            'NGAY_BD',
                            'NGAY_KT',
                            [
                                'attribute' => 'GHICHU',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return $model->GHICHU;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'STATUS',
                                'contentOptions' => ['style' => 'width:10%; white-space: normal;word-break: break-word;'],
                                'value' => function ($model) {
                                    return statusdonhang()[$model->STATUS];
                                },
                                'filter'=> statusdonhang(),
                                'filterType' => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options' => ['prompt' => ''],
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                            [
                                'attribute' => 'GHICHU',
                                'contentOptions' => ['style' => 'width:15%; white-space: normal;word-break: break-word;'],
                                'value' => function($model) {
                                    return ;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => Yii::$app->user->can('quanlyhocphi') ? '{duyetthuphitruoc}{delete}' : '',
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return $model->STATUS == 1 ? Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID], [
                                            'class' => 'btn btn-danger btn-flat',
                                            'data' => [
                                                'confirm' => Yii::t('app', 'Dữ liệu sẽ bị xóa vĩnh viễn không thể khôi phục lại.Bạn chắc chắn muốn xóa mục này?'),
                                                'method' => 'post',
                                            ],
                                        ]) : null;
                                    },
                                    'duyetthuphitruoc' => function ($url, $model) {
                                        return $model->STATUS == 1 ? '<span class="btn btn-primary duyetthuphitruoc" data-id="' . $model->ID . '">Duyệt</span>' : '<span class="btn btn-danger modieuchinh" data-id="' . $model->ID . '">Mở điều chỉnh</span>';
                                    },
                                ],
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
    $(document).on('click', '.duyetthuphitruoc', function() {
        Swal.fire({
            title: 'Bạn có chắc chắn đã thu học phí học sinh này không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'ĐÃ THU!',
            cancelButtonText: "CHƯA THU!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var id = $(this).data('id');
            $.ajax({
                url: '/quanlyhocphithutruoc/duyetthuphitruoc',
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
                    }
                }
            });
        }
        });
        
    });
    $(document).on('click', '.modieuchinh', function() {
        Swal.fire({
            title: 'Bạn có chắc chắn mở lại để điều chỉnh học sinh này không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'ĐÃ THU!',
            cancelButtonText: "CHƯA THU!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var id = $(this).data('id');
            $.ajax({
                url: '/quanlyhocphithutruoc/modieuchinh',
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
                    }
                }
            });
        }
        });
        
    });
JS;
$this->registerJs($script);
?>
