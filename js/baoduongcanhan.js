    function readFile() {
      if (this.files && this.files[0]) {
        var FR= new FileReader();
        FR.addEventListener("load", function(e) {
        document.getElementById("img").src = e.target.result;
        var width = 500;
        var height = 300;
        var image = new Image();
        image.src = e.target.result;
var dataURLToBlob = function(dataURL) {
    var BASE64_MARKER = ';base64,';
    if (dataURL.indexOf(BASE64_MARKER) == -1) {
        var parts = dataURL.split(',');
        var contentType = parts[0].split(':')[1];
        var raw = parts[1];

        return new Blob([raw], {type: contentType});
    }

    var parts = dataURL.split(BASE64_MARKER);
    var contentType = parts[0].split(':')[1];
    var raw = window.atob(parts[1]);
    var rawLength = raw.length;

    var uInt8Array = new Uint8Array(rawLength);

    for (var i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }

    return new Blob([uInt8Array], {type: contentType});
}
        image.onload = () => {
                // Resize the image
                var canvas = document.createElement('canvas'),
                    max_size = 800,// TODO : pull max size from a site config
                    width = image.width,
                    height = image.height;
                if (width > height) {
                    if (width > max_size) {
                        height *= max_size / width;
                        width = max_size;
                    }
                } else {
                    if (height > max_size) {
                        width *= max_size / height;
                        height = max_size;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                var dataUrl = canvas.toDataURL('image/jpeg');
                var resizedImage = dataURLToBlob(dataUrl);
                var ID_DOTBD = $("#ID_DOTBD").val();
                var urluploadimage = $("#urluploadimage").val();
                $.ajax({
                    url: urluploadimage,
                    method: 'post',
                    data: {
                        IMAGEBASE64: dataUrl,
                        ID_DOTBD: ID_DOTBD,
                    },
                    success:function(data) {
                        data = jQuery.parseJSON(data);
                        if (data.error == 0) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Upload ảnh thành công',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi upload ảnh',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        }
                        return 1;
                    }
                });
            };
            FR.onerror = error => console.log(error);
        });
        FR.readAsDataURL( this.files[0] );
      }
    }

    document.getElementById("inp").addEventListener("change", readFile);

    $(".xulycongviec").on( "click", function() {
        var ID_DOTBD = this.dataset.id_dotbd;
        var ID_THIETBI = this.dataset.id_thietbi;
        var MA_NOIDUNG = this.dataset.ma_noidung;
        var url = $("#url").val();
        var urlgetmodal = $("#urlgetmodal").val();
        var IS_DONE = $(this).prop('checked') ? 1 : 0;
        if (!IS_DONE) {
            $.ajax({
                url: url,
                method: 'post',
                data: {
                    ID_DOTBD: ID_DOTBD,
                    ID_THIETBI: ID_THIETBI,
                    IS_DONE: IS_DONE,
                    KETQUABAODUONG: '',
                    KIENNGHI: '',
                    MA_NOIDUNG: MA_NOIDUNG
                },
                success:function(data) {
                    // $("#ID_DOTBD").val('');
                    // $("#ID_THIETBI").val('');
                    // $("#MA_NOIDUNG").val('');
                    // $("#IS_DONE").val('');
                    $('#myModal').modal('hide');
                    data = jQuery.parseJSON(data);
                    if (!data.error) {
                        if(data.IS_DONE) {
                            $('#' + 'trangthai-' + data.MA_NOIDUNG + '-' + data.ID_THIETBI).removeClass('label-danger').addClass('label-success').html('<i class="fa fa-thumbs-o-up"></i>');
                        } else {
                            $('#' + 'trangthai-' + data.MA_NOIDUNG + '-' + data.ID_THIETBI).removeClass('label-success').addClass('label-danger').html('<i class="fa fa-clock-o"></i>');

                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Đã hủy hoàn thành',
                            showConfirmButton: false,
                            timer: 500
                        });
                    }
                    return 1;
                }
            });

            return 1;
        }

        $.ajax({
            url: urlgetmodal,
            method: 'post',
            data: {
                ID_DOTBD: ID_DOTBD,
                ID_THIETBI: ID_THIETBI,
                IS_DONE: IS_DONE,
                MA_NOIDUNG: MA_NOIDUNG
            },
            success:function(data) {
                $('#ketquabaoduong').html(data);
                $('#myModal').modal('show');
            }
        });
        
    });

    $("#hoanthanhconviec").on( "click", function() {
        var ID_DOTBD = $("#ID_DOTBD").val();
        var ID_THIETBI = $("#ID_THIETBI").val();
        var MA_NOIDUNG = $("#MA_NOIDUNG").val();
        var KETQUABAODUONG = $("#KETQUABAODUONG").val();
        var KIENNGHI = $("#KIENNGHI").val();
        var GHICHU = $("#GHICHU").val();
        var IS_DONE = $("#IS_DONE").val();
        var url = $("#url").val();
        var SOLIEUTHUCTE = {};
        $("input[name*='SOLIEUTHUCTE']").each(function(){
            SOLIEUTHUCTE[this.id] = $(this).val();
        });

        $.ajax({
            url: url,
            method: 'post',
            data: {
                ID_DOTBD: ID_DOTBD,
                ID_THIETBI: ID_THIETBI,
                IS_DONE: IS_DONE,
                KETQUABAODUONG: KETQUABAODUONG,
                KIENNGHI: KIENNGHI,
                SOLIEUTHUCTE: SOLIEUTHUCTE,
                GHICHU: GHICHU,
                MA_NOIDUNG: MA_NOIDUNG
            },
            success:function(data) {
                // $("#KIENNGHI").val('');
                // $("#ID_THIETBI").val('');
                // $("#MA_NOIDUNG").val('');
                // $("#KETQUABAODUONG").val('dat');
                // $("#IS_DONE").val('');
                $('#myModal').modal('hide');
                data = jQuery.parseJSON(data);
                if (!data.error) {
                    if(data.IS_DONE) {
                        $('#' + 'trangthai-' + data.MA_NOIDUNG + '-' + data.ID_THIETBI).removeClass('label-danger').addClass('label-success').html('<i class="fa fa-thumbs-o-up"></i>');
                    } else {
                        $('#' + 'trangthai-' + data.MA_NOIDUNG + '-' + data.ID_THIETBI).removeClass('label-success').addClass('label-danger').html('<i class="fa fa-clock-o"></i>');

                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã hoàn thành công việc',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            }
        });
    });
    $("#xacnhantatca").on( "click", function() {
      var ID_DOTBD = $("#ID_DOTBD").val();
      var urlxacnhan = $("#urlxacnhan").val();
      var KETQUABAODUONG = $("#KETQUABAODUONG").val();
        $.ajax({
            url: urlxacnhan ,
            method: 'post',
            data: {
                ID_DOTBD: ID_DOTBD,
                KETQUA: 1,
            },
            success:function(data) {
                if (!data.error) {
                    Swal.fire('Xác nhận thành công');
                }
            }
        });
    });

    $("#ketthucdotbaoduong").on( "click", function() {
      var ID_DOTBD = $("#ID_DOTBD").val();
      var urlketthuc = $("#urlketthuc").val();
      var KETQUABAODUONG = $("#KETQUABAODUONG").val();
        $.ajax({
            url: urlketthuc ,
            method: 'post',
            data: {
                ID_DOTBD: ID_DOTBD,
            },
            success:function(data) {
                if (!data.error) {
                    Swal.fire('Xác nhận thành công');
                }
            }
        });
    });

    $("#nhanvienhoanthanh").on( "click", function() {
      var ID_DOTBD = $("#ID_DOTBD").val();
      var urlnhanvienhoanthanh = $("#urlnhanvienhoanthanh").val();
        $.ajax({
            url: urlnhanvienhoanthanh ,
            method: 'post',
            data: {
                ID_DOTBD: ID_DOTBD,
            },
            success:function(data) {
                data = jQuery.parseJSON(data);
                console.log(data);
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: data.message,
                        buttons: true,
                        dangerMode: true
                    });
                } else {
                    $('#nhanvienhoanthanh').remove();
                    Swal.fire('Hoàn thành bảo dưỡng!');
                }
            }
        });
    });

    function readURL(input) {
        var formData = new FormData(input);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var ID_DOTBD = $("#ID_DOTBD").val();
            $.ajax({
                url: 'dotbaoduongcanhan/uploadanhdotbaoduong',
                method: 'post',
                data: {
                    formData: formData,
                    ID_DOTBD: ID_DOTBD
                },
                success:function(data) {
                    console.log(data);
                }
            });
        }
    }
    $("#image-dotbaoduong").change(function() {
    readURL(this);
    });