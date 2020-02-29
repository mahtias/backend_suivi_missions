<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:27
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class Familles extends Model
{
    protected $table = 'familles';

    public $timestamps = false;

    protected $guarded = ['id'];
}
