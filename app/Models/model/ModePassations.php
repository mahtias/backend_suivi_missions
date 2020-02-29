<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:42
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class ModePassations extends Model
{
    protected $table = 'mode_passations';

    public $timestamps = false;

    protected $guarded = ['id'];
}
