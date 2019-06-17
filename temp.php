                        

http://10.51.138.24/vnpt_mds/web/index.php

//DotbaoduongController

    public function actionCreatePost($MA_DOTBD, $ID_TRAM, $NGAY_BD, $ID_NHANVIEN)
    {
        if (Yii::$app->user->can('create-dbd')) {
            
            $model = new Dotbaoduong();
            $model->MA_DOTBD = $MA_DOTBD;
            $model->ID_TRAM = $ID_TRAM;
            $model->NGAY_BD = $NGAY_BD;
            $model->ID_NHANVIEN = $ID_NHANVIEN;
            $model->save(false);
            $log = new ActivitiesLog;
            $log->activity_type = 'maintenance-create';
            $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã tạo đợt bảo dưỡng ". $model->MA_DOTBD . ", ". $model->nHANVIEN->TEN_NHANVIEN ." làm nhóm trưởng.";
            $log->user_id = Yii::$app->user->identity->id;
            $log->create_at = time();
            $log->save();

            return $this->redirect(Yii::$app->request->referrer);
        } else {
            throw new ForbiddenHttpException;
        }
    }
'
                                        $.ajax({
                                            type: "POST",
                                            url: " '. Url::to([
                                                "nhomtbi/create-post", 
                                                'MA_NHOM' => '$("#nhomtbi-ma_nhom").val()',
                                                'TEN_NHOM' => '$("#nhomtbi-ten_nhom").val()',
                                            ]) .'",
                                            success: function(data) {
                                                $.pjax({container: "#p0"});
                                            }
                                        });
                                    '


                                $.pjax.reload({
                                    container: "#p0",
                                    async: false,
                                    type: "POST",
                                    url: "index.php?r=dotbaoduong/lencongviec&id='.$model->ID_DOTBD.'",
                                    data: {
                                        idthietbi : $(this).val()
                                    }
                                });
                                
                                $.ajax({
                                    type: "POST",
                                    url: "index.php?r=dotbaoduong/lencongviec&id='.$model->ID_DOTBD.'",
                                    data: {
                                        idthietbi : $(this).val()
                                    },
                                    success: function(data) {
                                        $.pjax({container: "#p0"});
                                    }
                                });

<?= Html::dropDownList(
                        'donvi',
                        '',
                        ArrayHelper::map(Donvi::find()->all(), 'ID_DONVI', 'TEN_DONVI'),
                        [
                            'prompt' => 'Chọn đơn vị',
                            'style' => ['margin-top' => '15px', 'margin-bottom' => '15px'],
                            'class' => 'form-control',
                            'id' => 'donvi',
                        ]
                    ) ?> 

<h1>
<?= date('d', (strtotime($model->NGAY_BD) - strtotime(date('Y-m-d')))) ." ngafy." ?>
</h1>

<?php



                $log = new ActivitiesLog;
                $log->activity_type = 'device-add';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm nhóm thiết bị ". $model->MA_NHOM;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();



            $log = new ActivitiesLog;
            $log->activity_type = 'user-remove';
            $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã xóa nhân viên ". $model->TEN_NHANVIEN;
            $log->user_id = Yii::$app->user->identity->id;
            $log->create_at = time();
            $log->save();
?>


<!--- ++++Form modal them ke hoach tren Dot bao duong -->
<div class="modal fade" id="themNoiDung" tabindex="-1" role="dialog" aria-labelledby="themNoiDungLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>   
            </div>
            <?php $modalForm = ActiveForm::begin();
                $kehoachModel = new Noidungcongviec;
            ?>
            <div class="modal-body">
                <div class="form-group col-md-4">
                    <?= $modalForm->field($kehoachModel, 'ID_THIETBI')->dropDownList(
                        ArrayHelper::map(Thietbitram::find()->where(['ID_TRAM' => $model->ID_TRAMVT])->all(), 'ID_THIETBI', 'iDLOAITB.TEN_THIETBI'),
                        [
                            'prompt' => 'Chọn thiết bị',
                            'onchange' => '
                                $.post("index.php?r=noidungbaotri/liststbt&id='.'"+$(this).val(), function( data ) {
                                    $("#kehoachbdtb-ma_noidung").html( data );
                                });
                            ',
                        ])
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <?= $modalForm->field($kehoachModel, 'MA_NOIDUNG')->dropDownList(
                        ArrayHelper::map(Noidungbaotri::find()->all(), 'MA_NOIDUNG', 'NOIDUNG'),
                        [
                            'prompt' => 'Chọn nội dung bảo dưỡng',
                            
                        ])
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <?= $modalForm->field($kehoachModel, 'ID_NHANVIEN')->dropDownList(
                        ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'),
                        [
                            'prompt' => 'Chọn nhân viên bảo dưỡng',
                        ])
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::a(
                    '<i class="glyphicon glyphicon-plus"></i> Lưu', 
                    '#', 
                    [
                        'class'=>'btn btn-primary',
                        'id' => 'addBtn',
                        'onclick' => '
                            var iddotbd = '.$model->ID_DOTBD.';
                            var idthiebi = $("#kehoachbdtb-id_thietbi").val();
                            var manoidung = $("#kehoachbdtb-ma_noidung").val();
                            var idnhanvien = $("#kehoachbdtb-id_nhanvien").val();

                            $.post("index.php?r=noidungcongviec/create-post&ID_DOTBD="+iddotbd+"&ID_THIETBI="+idthiebi+"&MA_NOIDUNG="+manoidung+"&ID_NHANVIEN="+idnhanvien+"");
                        '
                    ]
                )?>
            </div>
          <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- End cmn Modal form ==================== -->

<script type="text/javascript">
    
    view/kehoach.php
    ++bid;
    $man = $("table tbody tr:first").clone(true);

    $man.find("select").each(function(i,j) {
        $actionname = $(j).attr("id").split("-");
        $(j).attr("name","Kehoachbdtb"+"["+bid+"]"+"["+$actionname[2]+"]");
        $(j).attr("id","kehoachbdtb"+"-"+bid+"-"+$actionname[2]);
        $(this).parent().removeClass();
        $(this).parent().addClass("form-group field-kehoachbdtb"+"-"+bid+"-"+$actionname[2]+" "+"required");
    });
    $("table tbody").append( $man );
</script>

<?php

    'actionColumn' => [
        'template' => '{delete}',
        'buttons' => [
            'delete' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['data-method' => 'post']);
            }
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'delete') {
                $url ='index.php?r=kehoachbdtb/delete&ID_DOTBD='.$model->ID_DOTBD.'&ID_THIETBI='.$model->ID_THIETBI.'&MA_NOIDUNG='.$model->MA_NOIDUNG;
                return $url;
            }
        }
    ],
?>
<script type="text/javascript">
    
    $.post(index.php?r=kehoachbdtb/delete&ID_DOTBD='.$model->ID_DOTBD.'&ID_THIETBI='.$model->ID_THIETBI.'&MA_NOIDUNG='.$model->MA_NOIDUNG.');
    // $("input:checkbox:checked").parents("tr").remove();

                    $("input:checkbox:checked").parents("tr").remove();

    var man = $("table tbody tr:first").clone(true);
                    $("table > tbody > tr:first").before(man);

    pk : $("#w1-container").GridView("getSelectedRows");

man.find("select").each(function(i,j) {
    $actionname = $(j).attr("id").split("-");
    $(j).attr("name","Kehoachbdtb"+"["+bid+"]"+"["+$actionname[2]+"]");
    $(j).attr("id","kehoachbdtb"+"-"+bid+"-"+$actionname[2]);
    $(this).parent().removeClass();
    $(this).parent().addClass("form-group field-kehoachbdtb"+"-"+bid+"-"+$actionname[2]+" "+"required");
});

$("#addBtn").on('click', function () {
        var iddotbd = $("#noidungcongviec-id_dotbd").val();
        var idthietbi = $("#noidungcongviec-id_thietbi").val();
        var manoidung = $("#noidungcongviec-ma_noidung").val();
        var idnhanvien = $("#noidungcongviec-id_nhanvien").val();
        $.post("index.php?r=noidungcongviec/create-post&ID_DOTBD="+iddotbd+"&ID_THIETBI="+idthietbi+"&MA_NOIDUNG="+manoidung+"&ID_NHANVIEN="+idnhanvien);
        
    });

$.ajax({
    url: "kehoachbdtb/create",
    type: "post",
    data: { 
        "ID_DOTBD" : '.$model->ID_DOTBD.',
        "MA_NOIDUNG" : $("#kehoachbdtb-ma_noidung").val(),
        "ID_THIETBI" : $("#kehoachbdtb-id_thietbi").val(),
        "ID_NHANVIEN" : $("#kehoachbdtb-id_nhanvien").val(),
    } ,
    success: function (response) {

    },
});
</script>

            <div class="form-group col-md-12">
                <label>Tiến độ</label>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent ?>%;">
                        <?= $percent ?>%
                    </div>
                </div>    
            </div>

<?php 
    'template' => '{view}{update}{delete}',
    'urlCreator' => function ($action, $model, $key, $index) {
        if ($action === 'view') {
            $url ='index.php?r=tramvt/view&id='.$model->ID_TRAMVT;
            return $url;
        }
        if ($action === 'update') {
            $url ='index.php?r=tramvt/update&id='.$model->ID_TRAMVT;
            return $url;
        }
        if ($action === 'delete') {
            $url ='index.php?r=tramvt/delete&id='.$model->ID_TRAMVT;
            return $url;
        }
    }

?>
//gridview of thuchienbd/congviec         
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'ID_THIETBI',
                'value' => 'iDTHIETBI.TEN_THIETBI'
            ],
            [
                'attribute' => 'MA_NOIDUNG',
                'value' => 'mANOIDUNG.NOIDUNG'
            ],
            [
                'attribute' => 'ID_DOTBD',
                'value' => 'iDDOTBD.MA_DOTBD',
            ],
            [
                'attribute' => 'Trạng thái',
                'value' => 'iDDOTBD.TRANGTHAI'
            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>

<div class="box box-primary">
    <div class="box-body">
        <div class="col-sm-4"></div>
    </div>
    <div class="box-footer"></div>
</div>
<div class="box box-primary">
    <div class="box-body">
        
    </div>
</div>

$.post("index.php?r=noidungbaotri/create-post&MA_NOIDUNG="+manoidung+"&ID_THIETBI="+idthietbi+"NOIDUNG="+noidung+"");

$.post("index.php?r=noidungbaotri/create-post", {MA_NOIDUNG : manoidung, ID_THIETBI : idthietbi, NOIDUNG : noidung});