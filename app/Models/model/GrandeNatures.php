<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 10:42
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class GrandeNatures extends  Model
{
    protected $table = 'grande_natures';

    public $timestamps = false;

    protected $guarded = ['id'];
}
