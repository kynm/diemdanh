<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NhanvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'DANH SÁCH NHÂN VIÊN ĐƠN VỊ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nhanvien-index">
    <p>
        <?= (Yii::$app->user->can('quanlytruonghoc')) ? Html::a('<i class="fa fa-plus"></i> Thêm nhân viên', ['taomoinhanviendonvi'], ['class' => 'btn btn-primary btn-flat']) : '' ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'TEN_NHANVIEN',
                        'DIEN_THOAI',
                        'USER_NAME',
                        [
                            'attribute' => 'PHANQUYEN',
                            'value' => function($model)
                            {
                                $allrules = ArrayHelper::map($model->user->assignments, 'item_name', 'item_name');
                                $text = '';
                                if (Yii::$app->user->can('quanlytruonghoc') && $model->ID_NHANVIEN != Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
                                    $text .= '<input type="checkbox" name="quyendd" value="1" data-id="'  . $model->ID_NHANVIEN . '" class="phanquyennhanvien" ' .  (in_array('diemdanhlophoc', $allrules) ? 'checked' : '') . '> Diểm danh lớp học<br>';
                                    $text .= '<input type="checkbox" name="quyenddttt" data-id="'  . $model->ID_NHANVIEN . '" value="1" class="phanquyennhanvien"  ' .  (in_array('diemdanhtoantrungtam', $allrules) ? 'checked' : '') . '> Diểm danh toàn trung tâm<br>';
                                }
                                return $text;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => '',
                            'value' => function($model)
                            {
                                
                                return '<span class="btn btn-primary resetpassword" data-id="'  . $model->ID_NHANVIEN . '">Reset Password</span>';
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
    $(document).on('click', '.phanquyennhanvien', function() {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn phân quyền lại cho nhân viên này không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'CÓ!',
            cancelButtonText: "KHÔNG!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var capnhatghichu = $(this).val();
            var val = $(this).is(":checked") ? 1 : 0;
            var id = $(this).data('id');
            var name = $(this).attr("name");
            $.ajax({
                url: '/nhanvien/phanquyennhanvien',
                method: 'post',
                data: {
                    val: val,
                    name: name,
                    id: id,
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    if (!data.error) {
                        Swal.fire('Xác nhận thành công');
                    }
                }
            });
        }
        });
    });
    $(document).on('click', '.resetpassword', function() {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn Reset Password cho tài khoản này không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'CÓ!',
            cancelButtonText: "KHÔNG!"
        }).then((result) => {
        if (result['isConfirmed']) {
            var capnhatghichu = $(this).val();
            var id = $(this).data('id');
            $.ajax({
                url: '/nhanvien/resetpassword',
                method: 'post',
                data: {
                    id: id,
                },
                success:function(data) {
                    data = jQuery.parseJSON(data);
                    Swal.fire(data.message);
                }
            });
        }
        });
    });
JS;
$this->registerJs($script);
?>