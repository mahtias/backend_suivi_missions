<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 11:46
 */

namespace App\Model\GueiModel;

//document_ptbappms
use Illuminate\Database\Eloquent\Model;

class DocumentPtbappms extends Model
{
    protected $table = 'document_ptbappms';

    public $timestamps = false;

    protected $guarded = ['id'];
}
