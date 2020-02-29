<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 05/09/2019
 * Time: 10:17
 */

namespace App\Model\GueiModel;


use Illuminate\Database\Eloquent\Model;

class SouceFinancement extends Model
{
    protected $table = 'source_financements';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function typeFinancement(){
        return $this->belongsTo(TypeFinancements::class);
    }
}
