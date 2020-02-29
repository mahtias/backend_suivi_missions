<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 27/08/2019
 * Time: 16:04
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class MarcheContrats extends Model
{
    protected $table = 'engagements';

    public $timestamps = false;

    protected $guarded = ['id'];
}
