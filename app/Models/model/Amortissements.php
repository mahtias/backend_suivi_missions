<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:29
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class Amortissements extends Model
{
    protected $table = 'amortissements';

    public $timestamps = false;

    protected $guarded = ['id'];
}
