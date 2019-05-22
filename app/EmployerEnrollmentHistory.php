<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerEnrollmentHistory extends Model
{
    //
    protected $guarded = [];
    // Table Name
    protected $table = 'employer_enrollment_history';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
}
