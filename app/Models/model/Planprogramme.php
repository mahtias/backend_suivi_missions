<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Planprogramme extends Model
{
     protected $table = 'plan_programmes';

    public $timestamps = false;

    protected $guarded = ['id'];
    //relation entre planprogramme et structure programme
    public function structure_programme()
    {
        return $this->belongsTo(Structureprogramme::Class,'structure_programme_id');
    }
}
