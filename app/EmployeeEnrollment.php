<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeEnrollment extends Model
{
    //
    //
    protected $guarded = [];
    // Table Name
    protected $table = 'employee';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
 
}
