<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 12:13
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;


//structure_budgetaires
class StructureBudgetaires extends Model
{
    protected $table = 'structure_budgetaires';

    public $timestamps = false;

    protected $guarded = ['id'];
}
