<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NormeMission extends Model
{
   protected $table = 'norme_mission';

    public $timestamps = false;

    protected $guarded = ['id'];

    // public function mission()
    // {
    //     return $this->hasMany(Mission::class, 'categorie_missions_id');
    // }

   

   
}


