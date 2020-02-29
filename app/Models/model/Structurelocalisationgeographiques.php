<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Structurelocalisationgeographiques extends Model
{
    protected $table = 'structure_localisation_geographiques';

    public $timestamps = false;

    protected $guarded = ['id'];

    //relation entrer structurelocalisationgeographiques et localisation geo
    
    public function localisation_geographiques(){
       return $this->hasMany(Localisationgeographiques::Class,'structure_localisation_geographique_id','id');
    }
}
