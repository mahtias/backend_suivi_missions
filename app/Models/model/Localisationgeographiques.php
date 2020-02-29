<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Localisationgeographiques extends Model
{
   protected $table = 'localisation_geographiques';

    public $timestamps = false;

    protected $guarded = ['id'];

    //relation entrer localisationgeographiques et chapitre
    
    public function chapitres(){
       return $this->hasMany(Chapitre::Class,'localisation_geographique_id','id');
    }

    //relation entrer localisationgeographiques et structure local geo

    public function structure_localisation_geographique(){
        return $this->belongsTo(Structurelocalisationgeographiques::Class,'structure_localisation_geographique_id');
    }
}
