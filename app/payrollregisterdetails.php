<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payrollregisterdetails extends Model
{
    protected $guarded = [];
    // Table Name
    protected $table = 'payroll_register_details';
    // Primary Key
    protected $primaryKey = 'id';
    // timestamps
    public $timestamps = true;
}
