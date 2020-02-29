<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Structureadministrative extends Model
{
 protected $table = 'structure_administratives';

    public $timestamps = false;

    protected $guarded = ['id'];
    
    //reletion entre structureadministrative et servicegestionnairescredits

    public function Service_gestionnaires_credits()
    {
        return $this->hasMany(Servicegestionnairescredits::Class,'structure_administrative_id','id');
    }
}
