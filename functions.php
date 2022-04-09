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

    function statusbaohong()
    {
        return [
            0 => 'Chờ tiếp nhận',
            1 => 'Báo sai',
            2 => 'Đang xử lý',
            3 => 'Đã xử lý',
            4 => 'Đóng yêu cầu',
            5 => 'Xác nhận báo sai',
        ];
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

    function testbyaccount($matb)
    {
        $matb = trim(strtolower($matb));
        $request_url = 'https://cts.vnpt.vn:8085/LineTestAPI/TestbyAccount?accountName=' . $matb . '&serviceType=3';
        $data = [
          "accountName"        => $matb,
              "serviceType"        => 3,
        ];
        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
          'Authorization: Y3RzLmhubUAyOC8wMi8yMDIyIDE3OjA3',
          'Content-Type: application/json'
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
        return $response;

    }

    function getByAccount($matb)
    {
        $matb = trim(strtolower($matb));
        $request_url = 'https://cts.vnpt.vn:8085/LineTestAPI/GetByAccount?accountName=' . $matb . '&serviceType=3';
        $data = [
          "accountName"        => $matb,
              "serviceType"        => 3,
        ];
        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
          'Authorization: Y3RzLmhubUAyOC8wMi8yMDIyIDE3OjA3',
        ]);
        $response = curl_exec($curl);
       $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($httpcode == '0') {
            getByAccount($matb);
        }

        return $response;
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

    function ketqua32to78()
    {
        return [
            1 => 'Đã liên hệ hẹn lúc khác',
            2 => 'Đã thêm vào nhóm zalo',
            3 => 'Đã tư vấn nghiệp vụ',
            4 => 'Đã hướng dẫn sử dụng (GỬI DK01)',
            5 => 'Đã phát hành hóa đơn thành công',
            6 => 'Hướng dẫn nghiệp vụ khác',
            7 => 'Đã hủy dịch vụ',
            8 => 'Giải thể',
        ];
    }

?>