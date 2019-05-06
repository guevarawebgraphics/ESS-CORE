<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerContent extends Model
{
    //
    protected $guarded = [];
    // Table Name
    protected $table = 'employercontent';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

}
