<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 27/08/2019
 * Time: 15:55
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class Engagement extends Model
{
    protected $table = 'engagements';

    public $timestamps = false;

    protected $guarded = ['id'];
}
