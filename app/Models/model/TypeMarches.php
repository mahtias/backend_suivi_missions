<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:39
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class TypeMarches extends Model
{
    protected $table = 'type_marches';

    public $timestamps = false;

    protected $guarded = ['id'];
}
