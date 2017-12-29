    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID_DOTBD')->dropDownList(ArrayHelper::map(Dotbaoduong::find()->all(), 'ID_DOTBD', 'MA_DOTBD'));
    ?>

    <?= $form->field($model, 'ID_THIETBI')->textInput() ?>

    <?= $form->field($model, 'MA_NOIDUNG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_NHANVIEN')->dropDownList(ArrayHelper::map(Nhanvien::find()->all(), 'ID_NHANVIEN', 'TEN_NHANVIEN'));?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <p class="form-inline">
        <div class="form-group col-md-4">
            <label>Đợt bảo dưỡng</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->MA_DOTBD ; ?>">
        </div>
        <div class="form-group col-md-4">
            <label>Ngày bảo dưỡng</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->NGAY_BD ; ?>">
        </div>
        <div class="form-group col-md-4">
            <label>Nhóm trưởng</label>
            <input type="text" class="form-control" id="exp" disabled="true" value="<?= $model->tRUONGNHOM->TEN_NHANVIEN ; ?>">
        </div>
    </p>

    'style' => 'width: 150px'
<?php 
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

 $.ajax({
        url: "test.php",
        type: "post",
        data: values ,
        success: function (response) {
           // you will get response from your php page (what you echo or print)                 

        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }


    });


 $.post("index.php?r=kehoachbdtb/create&ID_DOTBD='.$model->ID_DOTBD.'&ID_THIETBI=+$(#kehoachbdtb-id_thietbi).val()+&MA_NOIDUNG=+$(#kehoachbdtb-ma_noidung).val()+&ID_NHANVIEN=+$(#kehoachbdtb-id_nhanvien).val()", 
                        function() {
                            
                    });


$.ajax({
    url: "kehoachbdtb/create",
    type: "post",
    data: { 
        "ID_DOTBD" : '.$model->ID_DOTBD.',
        "MA_NOIDUNG" : $(#kehoachbdtb-ma_noidung).val(),
        "ID_THIETBI" : $(#kehoachbdtb-id_thietbi).val(),
        "ID_NHANVIEN" : $(#kehoachbdtb-id_nhanvien).val(),
    } ,
    success: function (response) {

    },
});


        $query = Dotbaoduong::find()->where(['TRANGTHAI' => 'Kết thúc' ]);

                    <!-- 
            <div class="form-group col-md-12">
                <label>Tiến độ</label>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent ?>%;">
                        <?= $percent ?>%
                    </div>
                </div>    
            </div>
             -->


// 'template' => '{view}{update}{delete}',
// 'button' => [

// ]
// 'urlCreator' => function ($action, $model, $key, $index) {
//     if ($action === 'view') {
//         $url ='index.php?r=tramvt/view&id='.$model->ID_TRAMVT;
//         return $url;
//     }
//     if ($action === 'update') {
//         $url ='index.php?r=tramvt/update&id='.$model->ID_TRAMVT;
//         return $url;
//     }
//     if ($action === 'delete') {
//         $url ='index.php?r=tramvt/delete&id='.$model->ID_TRAMVT;
//         return $url;
//     }
// }