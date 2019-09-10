<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeePersonalInfo extends Model
{
    protected $guarded = [];
    // Table Name
    protected $table = 'employee_personal_information';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true; 
  
}
