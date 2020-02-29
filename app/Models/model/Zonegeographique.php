<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Zonegeographique extends Model
{
   protected $table = 'zone_geographiques';

    public $timestamps = false;

    protected $guarded = ['id'];
    
    //relation entrer zoneGeographique et indicateur
    public function indicateurs(){
       return $this->hasMany(indicateur::Class);
    }
}
