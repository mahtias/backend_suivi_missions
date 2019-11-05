<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImputationMission extends Model
{
    //
    protected $table = 'imputation_missions';

    public $timestamps = false;

    protected $guarded = ['id'];


    // relation entre imputation et mission
    public function mission_imputation(){
        return $this->belongsTo(Mission::class, 'mission_id','id');
    }

    // relation entre imputationMission et plan budgetaire

}
