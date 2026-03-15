<?php

namespace App\Imports;

use App\Models\Produit;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProduitsImport implements ToCollection, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new Produit([
    //         //
    //     ]);
    // }
    public function collection(Collection $rows)
    {
        $cpt = 0;
        foreach ($rows as $key => $line)
        {
            if(count($line)>0 && $key > 0){
                // dd(self::rules());
                $validator = Validator::make($line->toArray(),self::rules());
                if (!$validator->fails()) {
                    // $validator->errors();
                    try {
                        $result = Produit::createOrUpdate($line);
                        if (!$result) $cpt++;
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }else{
                    $validator->errors()->add('field', 'Something is wrong with this field!');
                    $cpt++;
                }
            }
        }
        return $cpt;
    }

    // limitation de la memoire par 1000
    public function chunkSize(): int
    {
        return 1000;
    }
    static function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required',
            '3' => 'required',
            '5' => 'required',
            '6' => 'required',
            '7' => 'required',
            '9' => 'required',
            '10' => 'required',
            '11' => 'required',
            '12' => 'required',
            '13' => 'required',
        ];
    }
}
