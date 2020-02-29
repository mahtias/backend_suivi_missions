<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Structureprogramme extends Model
{
         protected $table = 'structure_programmes';

    public $timestamps = false;

    protected $guarded = ['id'];

    //relation entre structure programme et plan programme
    public function plan_programmes()
    {
        return $this->hasMany(Planprogramme::Class,'structure_programme_id','id');
    }
}
