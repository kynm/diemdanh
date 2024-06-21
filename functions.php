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

?>