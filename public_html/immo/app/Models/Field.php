<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $guarded = ['id'];

    //Relationship
    public function type_field()
    {
        return $this->belongsTo(TypeField::class);
    }

    public function type_document()
    {
        return $this->belongsTo(TypeDocument::class);
    }

    public function getLabelAttribute(){
        return $this->attributes['label']??$this->attributes['name'];
    }

    public function infos()
    {
        return $this->hasMany(Info::class);
    }

    public function getInfo($document_id){
        return $this->infos->where('document_id',$document_id)->first();
        // return $info->value??"---";
    }
}
