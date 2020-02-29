<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 10:13
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class Titre extends Model
{
    protected $table = 'titres';

    public $timestamps = false;

    protected $guarded = ['id'];
}
