<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_personal_information_preview extends Model
{
    protected $guarded = [];
    // Table Name
    protected $table = 'employee_personal_information_preview';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
}
