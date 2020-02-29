<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:08
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class Mandats extends Model
{
    protected $table = 'mandats';

    public $timestamps = false;

    protected $guarded = ['id'];
}
