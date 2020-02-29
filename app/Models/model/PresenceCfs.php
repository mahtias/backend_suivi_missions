<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:59
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;
//presence_cfs
class PresenceCfs extends Model
{
    protected $table = 'presence_cfs';

    public $timestamps = false;

    protected $guarded = ['id'];
}
