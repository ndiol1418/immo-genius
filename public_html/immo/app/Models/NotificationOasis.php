<?php

namespace App\Models;

use App\Exports\CommandesExport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class NotificationOasis extends Model
{
    use HasFactory;
    public static function sendEmail($subject,$msg,$attachments){

    }
    static function createJsonFile($array_input,$fileName){
        return Excel::store(new CommandesExport($array_input), 'invoicex.xls');
        // return (new CommandesExport($array_input))->download('invoices.xlsx');
        // dd($response);
        // Excel::download(new CommandesExport, 'invoicex.xls');
         // dd($writer);
         // if(!file_exists(WWW_ROOT.$fileName)){
         //   touch(WWW_ROOT.$fileName);
         // }
         // $fp = fopen(WWW_ROOT.$fileName, 'w');
         // foreach ($array_input as $fields) {
         //   fputcsv($fp, $fields);
         // }

         // fclose($fp);
           // fputcsv(WWW_ROOT.$fileName,$array_input);
         return $fileName??false;
    }
    static function notifierMail($fileName,$subject,$msg){
         $file = $fileName;
         $chemin = file_get_contents($file);
         $base64 = base64_encode($chemin);
         # code...
         $attachments [] = [
                             "Content-type" => "application/json",
                             "Filename" => $fileName,
                             "content" => $base64
                         ];

         unlink($file);
         return self::sendEmail($subject,$msg,$attachments);
    }
}
