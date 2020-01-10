<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueMission extends Model
{
   protected $table = 'historique_missions';

   // public $timestamps = false;

    protected $guarded = ['id'];

    public function missions()
    {
        return $this->belongsTo(Mission::class, 'mission');
    }

   

   
}


