<?php

namespace App\Actions;



use App\Models\languages;
use Illuminate\Support\Str;

class HanedRulesValidation
{
 public static function handle($basic , $data_lang){
     $langs = languages::query()->pluck('prefix');
     foreach ($langs as $lang){
         foreach ($data_lang as $item){
             $name = Str::before($item,':');
             $validation = Str::after($item,':');
             $basic[$lang.'_'.$name] = $validation;
         }
     }
     return $basic;
 }
}
