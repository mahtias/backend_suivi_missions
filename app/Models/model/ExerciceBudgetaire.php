<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 04/09/2019
 * Time: 01:25
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class ExerciceBudgetaire extends Model
{
    protected $table = 'exercice_budgetaires';

    public $timestamps = false;

    protected $guarded = ['id'];
}
