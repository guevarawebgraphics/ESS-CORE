<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payroll_register_details_preview extends Model
{
    protected $guarded = [];
    // Table Name
    protected $table = 'payroll_register_details_preview';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
}
