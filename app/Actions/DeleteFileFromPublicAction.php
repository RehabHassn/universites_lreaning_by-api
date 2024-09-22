<?php

namespace App\Actions;

class DeleteFileFromPublicAction
{
    public static function delete($folder , $name)
    {
        // images  products/ab.png
        $path_file = public_path($folder.'/'.$name);
        if(file_exists($path_file)){
            unlink($path_file);
        }
    }
}
