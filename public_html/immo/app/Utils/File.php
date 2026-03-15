<?php

namespace App\Utils;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class File
{
    static function uploadFile(UploadedFile $uploadFile, $folder,array $extensions = [], $randomName = "upload") {
        if($uploadFile->isValid() && in_array(strtolower($uploadFile->extension()), $extensions)) {
            $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
            $rand = substr(str_shuffle(str_repeat($alphabet, 20)),0, 4);
            $filename =  $rand . Str::slug($randomName) . '.' . $uploadFile->extension();
            try {
                $file = $uploadFile->move(public_path($folder), $filename);
                $path = $folder. '/' . $filename;
                return $path; //Update Image
            } catch (\Throwable $th) {
                return false;
            }
        }
        return false;
    }
}
