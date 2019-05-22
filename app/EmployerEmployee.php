<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerEmployee extends Model
{
    //
    protected $guarded = [];
    // Table Name
    protected $table = 'employer_and_employee';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
}
