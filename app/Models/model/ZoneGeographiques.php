<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:49
 */

namespace App\Model\GueiModel;

//
use Illuminate\Database\Eloquent\Model;

class ZoneGeographiques extends Model
{
    protected $table = 'zone_geographiques';

    public $timestamps = false;

    protected $guarded = ['id'];
}
