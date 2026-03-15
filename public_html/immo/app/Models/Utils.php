<?php

namespace App\Models;

use App\Utils\File;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class Utils extends Model
{
    use HasFactory;
    static function dataRequest($res){
        if(request()->has('debut') && request()->has('fin')) {
            $debut = Carbon::createFromFormat('Y-m', request('debut'));
            $fin = Carbon::createFromFormat('Y-m', request('fin'));
            $array_1 = $res['data'];
            return $array_1->get()->filter(function($item) use ($debut, $fin) {
                $item = Carbon::createFromDate($item->commande_date);
                $date = Carbon::createFromDate($item->year, $item->month, 1);
                return $date->isBetween($debut,$fin);
            })->sum('montant_ht');
        }
        return false;
    }

    static function savePJ($files,$model=null,$dossier,$id){
        if(count($files) == 0) return false;
        foreach ($files as $tmp_piece) {
            // $ext = $tmp_piece['file']->extension();
            $extensions = ['png','jpeg','jpg','gif'];
            $uploadFile = self::uploadFile($tmp_piece['file'],"uploads/".$dossier, $extensions);
            if($uploadFile) {
                if (Auth::user()->image) {
                    # code...
                    $image = Auth::user()->image;
                    $image->update(['url'=>$uploadFile]);
                }else{
                    Image::create([
                        // 'name' => $tmp_piece['name'],
                        'url' => $uploadFile,
                        'imageable_id' => $id,
                        'imageable_type' => $model??'',
                    ]);
                }
            }
        }
        return true;

    }

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
