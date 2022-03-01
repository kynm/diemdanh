$('form').submit(function(e)
{  
    $(this).find("button[type='submit']").prop('disabled',true);
});

$('form').change(function(e)
{  
    $(this).find("button[type='submit']").attr('disabled',false);
});

$(document).ready(function() {
    $("#kttrangthaithuebao").on( "click", function() {
      var ma_tb = $(this).data('matb');
      console.log(ma_tb);
        $.ajax({
            url: '/baohong/testbyaccount' ,
            method: 'post',
            data: {
                ma_tb: ma_tb,
            },
            success:function(data) {
                console.log(data);
                if (!data.error) {
                    Swal.fire(data);
                }
            }
        });
    });

    $("#ktttthuebao").on( "click", function() {
      var ma_tb = $(this).data('matb');
      console.log(ma_tb);
        $.ajax({
            url: '/baohong/kiemtrathongtinthuebao' ,
            method: 'post',
            data: {
                ma_tb: ma_tb,
            },
            success:function(data) {
                console.log(data);
                if (!data.error) {
                    Swal.fire(data);
                }
            }
        });
    });

    $("#nhanxuly").on( "click", function() {
        if (confirm("Bạn có chắc chắn nhận yêu cầu xử lý?") == true) {
        var id = $(this).data('id');
            $.ajax({
                url: '/baohong/nhanxuly?id=' + id ,
                method: 'post',
                data: {
                    id: id,
                },
                success:function(data) {
                    if (!data.error) {
                        Swal.fire('Xác nhận thành công');
                        location.reload();
                    }
                }
            });
        } else {
          Swal.fire('Đã xác nhận hủy');
        }

    });
});