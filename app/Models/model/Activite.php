<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 27/08/2019
 * Time: 14:58
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    protected $table = 'activites';

    public $timestamps = false;

    protected $guarded = ['id'];
}
