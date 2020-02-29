<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
      protected $table = 'sections';

    public $timestamps = false;

    protected $guarded = ['id'];
    
    //relation entre section et nature de section
    public function nature_section()
    {
      return $this->belongsTo(Naturesection::Class,'naturesection_id');
    }
}
