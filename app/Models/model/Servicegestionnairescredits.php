<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Servicegestionnairescredits extends Model
{
    protected $table = 'service_gestionnaires_credits';

    public $timestamps = false;

    protected $guarded = ['id'];

    //relation entre service gestionnaire et structure administrative
    public function structure_administrative()
    {
        return $this->belongsTo(Structureadministrative::Class,'structure_administrative_id');
    }
}
