<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $table = 'missions';

    public $timestamps = false;

    protected $guarded = ['id'];

    // protected $casts = [
    //     'date_mission' => 'date:d/m/Y',
    //     'date_depart' => 'date:d/m/Y',
    //     'date_retour' => 'date:d/m/Y',
    //     'date_visa_cf' => 'date:d/m/Y',

    // ];

    // public function imputations(){
    //     return $this->belongsTo(ImputationMission::class, 'mission_id');
    // }
    // relation entre categorie mission et mission 

    public function categorie_mission()
    {
        return $this->belongsTo(CategorieMission::class, 'categorie_missions_id','id');

    }

    public function historique_missions()
    {
      return $this->hasMany(HistoriqueMission::class, 'mission','id');
      // ->
      // with('missions')
      // ->latest()->first();

    }

}
