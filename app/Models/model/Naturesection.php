<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Naturesection extends Model
{
      protected $table = 'nature_sections';

    public $timestamps = false;

    protected $guarded = ['id'];

    //relation entre nature section et section
    public function sections()
    {
      return $this->hasMany(Section::Class,'naturesection_id','id');
    }
}
