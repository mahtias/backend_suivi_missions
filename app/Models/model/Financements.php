<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:52
 */

namespace App\Model\GueiModel;

//financements
use Illuminate\Database\Eloquent\Model;

class Financements extends Model
{
    protected $table = 'financements';

    public $timestamps = false;

    protected $guarded = ['id'];
}
