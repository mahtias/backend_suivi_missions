<?php
namespace App\Model\GueiModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 27/08/2019
 * Time: 13:47
 */

class BudgetTransfer extends Model
{
    protected $table = 'budget_transferts';

    public $timestamps = false;

    protected $guarded = ['id'];
}
