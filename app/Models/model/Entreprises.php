<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:25
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class Entreprises extends Model
{
    protected $table = 'entreprises';

    public $timestamps = false;

    protected $guarded = ['id'];
}
