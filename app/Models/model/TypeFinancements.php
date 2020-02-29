<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 10:21
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class TypeFinancements extends Model
{
    protected $table = 'type_financements';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function souceFinancement(){
        return $this->$this->hasMany(SouceFinancement::class,"source_financement_id");
    }
}
