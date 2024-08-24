<?php
    function formatnumber ($number , int $decimals = 0 , string $dec_point = "." , string $thousands_sep = ",")
    {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }

    function sendtelegrammessage($chatId, $message = 'Test text')
    {
        return 1;
        \Yii::$app->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    }

    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    }

    function except_pass()
    {
        return [
            '12345678', '123456789', '123456',
        ];
    }

    function dateofmonth()
    {
        return [
            0 => 'CHỦ NHẬT',
            1 => 'THỨ 2',
            2 => 'THỨ 3',
            3 => 'THỨ 4',
            4 => 'THỨ 5',
            5 => 'THỨ 6',
            6 => 'THỨ 7',
        ];
    }

    function statusdonvi()
    {
        return [
            0 => 'HẾT HẠN',
            1 => 'ĐANG THỬ NGHIỆM',
            2 => 'ĐANG HOẠT ĐỘNG CHÍNH THỨC',
        ];
    }

    function colorstatusdonvi($status)
    {
        $color = '';
        switch ($status) {
            case 0:
                $color = 'red';
                break;
            case 1:
                $color = '#f39c12';
                break;
            case 2:
                $color = 'green';
                break;
            
            default:
                $color = '#1E90FF';
                break;
        }

        return $color;
    }

    function colorsthuhocphitheongay($ngay)
    {
        $date1=date_create($ngay);
        $date2=date_create();
        if ($date1 < $date2) {
            $color = 'red';
            return $color;
        }
        $diffs = $date1->diff($date2)->format("%a");
        $color = '';
        if ($diffs < 3 && $diffs >= 1) {
            $color = '#b18e05';
        }
        if ($diffs < 1) {
            $color = 'red';
        }

        return $color;
    }

    function colorsthuhocphi($so)
    {
        $color = '';
        if ($so < 3 && $so >= 1) {
            $color = '#b18e05';
        }
        if ($so < 1) {
            $color = 'red';
        }

        return $color;
    }

    function statusdonhang()
    {
        return [
            0 => 'TỪ CHỐI',
            1 => 'CHỜ DUYỆT',
            2 => 'ĐÃ DUYỆT',
        ];
    }

    function statusthutien()
    {
        return [
            0 => 'CHƯA ĐÓNG',
            1 => 'ĐÃ ĐÓNG',
        ];
    }

    function statustintuc()
    {
        return [
            0 => 'ĐÓNG',
            1 => 'MỞ',
        ];
    }

    function loaidonhang() {
        return [
            1 => 'ĐĂNG KÝ MỚI',
            2 => 'MUA THÊM GÓI',
        ];
    }

    function sendmail($email, $title, $body)
    {
        return Yii::$app->mailer
        ->compose()
        ->setFrom('thongbao@easycheck.io.vn')
        ->setTo($email)
        ->setSubject($title)
        ->setHtmlBody($body)
        ->send();
    }

    function dsphanquyen()
    {
        return [
            1 => 'Điểm danh học sinh',
            2 => 'Điểm danh toàn trung tâm',
        ];
    }

?>