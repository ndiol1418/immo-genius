<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    protected $fillable = ['libelle','attributs','valeurs','identifiant'];
   // protected $casts = [
     //   'attributs' => 'array'
   // ];
    public static function getListe($libelle){
        return Self::where('libelle',$libelle)->first();
    }

    public function getValeursAttribute(){
	//dd('bonjour');
        if(count($this->attributes) > 0){
            $csv = $this->attributes['valeurs'];
            $attributs = $this->attributs;
            $lignes = explode(PHP_EOL, $csv);
            $lignes = array_map('trim', $lignes);
            $tableau = [];
            foreach($lignes as $i => $ligne){
                $ligne = explode('\r',$ligne);
                $cells = explode(';',$ligne[0]);
                foreach($attributs as $j => $attribut){
                    $tableau[$i][$attribut] = $cells[$j]??null;
                }
            }
            return $tableau;
        }
        return [];

    }

    public function getAttributsAttribute(){
        if(count($this->attributes)>0){
            $csv = $this->attributes['attributs'];
            return explode(";", $csv);
        }
        return [];
    }

    public function getIdentifiantAttribute(){
      if(isset($this->attributes['identifiant'])) return $this->attributes['identifiant'];
      else return null;
    }

    public function getLabelAttribute(){
        if(count($this->attributs)> 0){
            return $this->attributes['label']??$this->attributs[0];
        }
        return false;
    }

    public function getElement($identifiant){
	//dd($this->valeurs);
	//dd($this);
        foreach($this->valeurs as $element){
            if($this->identifiant){
                if(isset($element[$this->identifiant]) && ($element[$this->identifiant] == (string)$identifiant)){
                    return $element;
                }
            }
        }
        return null;
    }

    public function displayElement($identifiant){
	//dd($identifiant);	
        $element = $this->getElement($identifiant);

        //array_shift($element);
        if($element[$this->identifiant] == $element[$this->label]){
            return $element[$this->identifiant];
        }
        return $element[$this->identifiant].' - '.$element[$this->label];
    }

    public function verifIdentifiant(){
        if($this->identifiant) return true;
        else return false;
    }

    public function DataAttrWithCsv($file){
       return file_get_contents($file,true);
    }

}
