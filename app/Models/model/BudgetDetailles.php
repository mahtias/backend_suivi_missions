<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 10:50
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class BudgetDetailles extends Model
{
    protected $table = 'budget_detailles';

    public $timestamps = false;

    protected $guarded = ['id'];
}
