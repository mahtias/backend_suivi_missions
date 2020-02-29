<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:56
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

//
class EtapesMarches extends Model
{
    protected $table = 'etapes_marches';

    public $timestamps = false;

    protected $guarded = ['id'];
}
