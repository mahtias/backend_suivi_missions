<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 02/09/2019
 * Time: 09:59
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class StructureActivite extends Model
{
    protected $table = 'structure_activites';

    public $timestamps = false;

    protected $guarded = ['id'];
}
