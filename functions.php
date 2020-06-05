<?php
    function formatnumber ($number , int $decimals = 0 , string $dec_point = "," , string $thousands_sep = ".")
    {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }
?>