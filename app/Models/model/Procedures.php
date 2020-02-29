<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:06
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class Procedures extends Model
{
    protected $table = 'procedures';

    public $timestamps = false;

    protected $guarded = ['id'];
}
