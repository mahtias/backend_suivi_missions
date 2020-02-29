<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Planfonctionnelle extends Model
{
     protected $table = 'plan_fonctionnelles';

    public $timestamps = false;

    protected $guarded = ['id'];

    //relation entre plan fonctionnelle et structure fonctionnelle
    public function structure_fonctionnelle()
    {
        return $this->belongsTo(Structurefonctionnelle::Class,'structure_fonctionnelle_id');
    }
}
