<?php

namespace App\Model\FabriceModel;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    protected $table = 'unites';

    public $timestamps = false;

    protected $guarded = ['id'];
}
