<?php

namespace App\Helpers;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/02/2019
 * Time: 11:57
 */

class Tool {

    static function ucwords($str){
        $str = mb_ucwords(mb_strtolower($str,'UTF-8'));

        $search = [' Tnhh ',' Cp ','Sx','Xnk','Tttm'];
        $replace = [' TNHH ',' CP ','SX','XNK','TTTM'];
        return str_replace($search,$replace,$str);
    }

}