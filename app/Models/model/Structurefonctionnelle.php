<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class structurefonctionnelle extends Model
{
      protected $table = 'structure_fonctionnelles';

    public $timestamps = false;

    protected $guarded = ['id'];
    //relation entre structure fonctionnelle et plan fonctionnelle
    public function planfonctionnelles()
    {
      return $this->hasMany(planfonctionnelle::Class);
    }
}
