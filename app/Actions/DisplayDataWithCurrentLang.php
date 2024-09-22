<?php
namespace App\Actions;
class DisplayDataWithCurrentLang{
    public static function display($data)
    {
        $result =json_decode($data,true);
        return $result[app()->getLocale()]??null;
    }
}
