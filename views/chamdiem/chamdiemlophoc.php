<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
$this->title = $chamdiem->lop->TEN_LOP;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('/lophoc/_detail', ['model' => $chamdiem->lop,]) ?>
</div>
<?php if (Yii::$app->user->can('diemdanhlophoc') && $chamdiem->lop->STATUS == 1):?>
    <?= $this->render('/partial/_chamdiem', ['model' => $chamdiem->lop,]) ?>
    <div class="daivt-view">
        <?= $this->render('_form_chamdiem', ['model' => $chamdiem, 'idlophoc' => $chamdiem->ID_LOP,]) ?>
    </div>
<?php endif; ?>
<div class="lophoc-index">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'TIEUDE',
                                'value' => function($model) {
                                    return Html::a($model->TIEUDE, ['capnhatchamdiem', 'id' => $model->ID]);
                                    return Yii::$app->formatter->asDatetime($model->NGAY_CHAMDIEM, 'php:d/m/Y');
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'NGAY_CHAMDIEM',
                                'value' => function($model) {
                                    return '<input class="form-control suangaychamdiem" data-id="' . $model->ID . '" type="date" value="' . $model->NGAY_CHAMDIEM . '">';;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'SOHOCSINH',
                                'value' => function($model) {
                                    return $model->getDschitietchamdiem()->count();
                                },
                            ],
                            [
                                'attribute' => 'CREATED_AT',
                                'value' => function($model) {
                                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d/m/Y');
                                },
                            ],
                            [
                                'attribute' => '',
                                'value' => function($model) {
                                    return '<span class="btn btn-danger xoachamdiem" data-id="' . $model->ID . '">Xóa</span>' . Html::a("Xem chi tiết", ['view', 'id' => $model->ID], ['class'=> 'btn btn-primary']);;
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
    $(document).on('click', '.xoachamdiem', function() {
        Swal.fire({
            title: 'Dữ liệu sẽ bị xóa vĩnh viễn, không thể khôi phục lại.Bạn có chắc chắc muốn xóa lượt chấm điểm không?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Xóa ngay!',
            cancelButtonText: "Không!"
        }).then((result) => {
            if (result['isConfirmed']) {
                var id = $(this).data('id');
                $.ajax({
                    url: '/chamdiem/xoachamdiem',
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
    $(document).on('change', '.suangaychamdiem', function() {
        var id = $(this).data('id');
        var ngay = $(this).val();
        $.ajax({
            url: '/chamdiem/suangaychamdiem',
            method: 'post',
            data: {
                id: id,
                ngay: ngay,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                Swal.fire(data.message);
            }
        });
    });
JS;
$this->registerJs($script);
?>