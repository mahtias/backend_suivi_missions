<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 10:53
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class MvalidationBudgetDetailles extends Model
{
    protected $table = 'mvalidation_budget_detailles';

    public $timestamps = false;

    protected $guarded = ['id'];
}
