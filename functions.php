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
?>