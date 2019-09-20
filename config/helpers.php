<?php
/**
 * Created by PhpStorm.
 * User: tradade
 * Date: 03/12/2018
 * Time: 10:39
 */

if (!function_exists('money_format')) {
    function money_format($n)
    {
        // first strip any formatting;
        $n = (0 + str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n / 1000000000000), 1) . ' nghìn tỷ';
        else if ($n > 1000000000) return round(($n / 1000000000), 1) . ' tỷ';
        else if ($n > 1000000) return round(($n / 1000000), 1) . ' triệu';
        else if ($n > 1000) return round(($n / 1000), 1) . ' nghìn';

        return number_format($n);
    }
}
