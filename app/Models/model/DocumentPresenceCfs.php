<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 12:02
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;
//
class DocumentPresenceCfs extends Model
{
    protected $table = 'document_presence_cfs';

    public $timestamps = false;

    protected $guarded = ['id'];
}
