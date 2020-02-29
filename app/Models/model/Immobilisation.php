<?php
/**
 * Created by IntelliJ IDEA.
 * User: Guei
 * Date: 27/08/2019
 * Time: 16:12
 */

namespace App\Model\GueiModel;


class Immobilisation
{
    protected $table = 'immobilisations';

    public $timestamps = false;

    protected $guarded = ['id'];
}
