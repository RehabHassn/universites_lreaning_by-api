<?php

namespace App\Actions;

use App\Models\languages;
use Illuminate\Support\Str;

class HandelDataBeforeSaveAction
{
 public static function handle($data)
 {

     $languages = languages::query()->pluck('prefix');
     $output = [];
     //dd($data);
     foreach ($data as $key => $value) {
         $lang_exist_at_input = 0;
         foreach ($languages as $language) {
             if (Str::contains($key, $language.'_')) {
                 $input_name = Str::replace($language, '', $key);
                 $input_name = Str::replace('_', '', $input_name);
                 $output[$input_name][$language] = $value;
                 $lang_exist_at_input = 1;
             }
         }
         if ($lang_exist_at_input == 0) {
             $output[$key] = $value;
         }
     }

     foreach ($output as $key => $value) {
         if (is_array($value)) {
             $output[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
         }
     }

     return $output;


 }
}
