<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ESSBase extends Model
{
    protected $table = "ess_basetable";

     // Primary Key
     public $primaryKey = 'id';
}
