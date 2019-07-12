<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payrollregister extends Model
{
    protected $guarded = [];
    // Table Name
    protected $table = 'payrollregister';
    // Primary Key
    protected $primaryKey = 'id';
    // timestamps
    public $timestamps = true;
}
