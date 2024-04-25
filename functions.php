<?php
    function formatnumber ($number , int $decimals = 0 , string $dec_point = "." , string $thousands_sep = ",")
    {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }

    function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
        // return number_format($angle * $earthRadius);
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

    function colorstatus($status)
    {
        $color = '';
        switch ($status) {
            case 0:
                $color = 'red';
                break;
            case 1:
                $color = '#008000';
                break;
            case 2:
                $color = '#FFD700';
                break;
            case 3:
                $color = '#008000';
                break;
            case 4:
                $color = '#1E90FF';
                break;
            case 5:
                $color = '#1E90FF';
                break;
            
            default:
                $color = '#1E90FF';
                break;
        }

        return $color;
    }

    function colorgiahan($model)
    {
        $color = '#1E90FF';
        $now = time(); // or your date as well
        $your_date = strtotime($model->NGAY_HH);
        $datediff = $your_date - $now;
        $datediff = round($datediff / (60 * 60 * 24));
        if (!$model->ngay_lh && $datediff < 7 && $model->ketqua != 5) {
            $color = 'red';
        }
        if ($model->ketqua == 5) {
            $color = 'green';
        }

        return $color;
    }

    function colorketqua($ketqua)
    {
        if ($ketqua) {
            return 'green';
        }

        return 'red';
    }

    function ketquatxhoadon()
    {
        return [
            1 => 'Đồng ý sử dụng dịch vụ',
            2 => 'Ký hợp đồng',
            3 => 'Đã thu tiền',
            4 => 'Đã hoàn thiện, bàn giao cho khách hàng',
            5 => 'Đã dùng VNPT từ trước',
            6 => 'Đã dùng dùng của doanh nghiệp khác',
            7 => 'Giải thể',
            8 => 'Sát nhập',
            9 => 'Hẹn khi khác gọi lại',
        ];
    }
    
    function hinhthuctx()
    {
      return [
            1 => 'Gọi điện',
            2 => 'Gặp trực tiếp',
            3 => 'Liên hệ qua Zalo,facebook,..',
            4 => 'Khác',
        ];
    }

    function ketquagiahan()
    {
        return [
            0 => 'Chưa liên hệ',
            1 => 'Chưa đồng gia hạn',
            2 => 'Không liên hệ được',
            3 => 'Đã liên hệ hẹn lúc khác',
            4 => 'Lý do khác',
            5 => 'Đã gia hạn',
            6 => 'Đã hủy dịch vụ',
            7 => 'Giải thể',
            8 => 'Đã dùng nhà mạng khác',
        ];
    }

    function ketquasuamau()
    {
        return [
            0 => 'Chưa liên hệ',
            1 => 'Yêu cầu sửa mẫu hóa đơn',
            2 => 'Đã sửa mẫu hóa đơn',
            3 => 'Đóng phiếu',
            4 => 'Không chuẩn hóa',
        ];
    }

    function rand_string( $length ) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

}

?>