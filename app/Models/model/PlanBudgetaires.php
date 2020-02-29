<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 10:26
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class PlanBudgetaires extends Model
{
    protected $table = 'plan_budgetaires';

    public $timestamps = false;

    protected $guarded = ['id'];
}
