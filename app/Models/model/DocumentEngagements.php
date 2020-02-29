<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:18
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class DocumentEngagements extends Model
{
    protected $table = 'document_engagements';

    public $timestamps = false;

    protected $guarded = ['id'];
}
