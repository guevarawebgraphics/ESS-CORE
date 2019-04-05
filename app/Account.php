<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $guarded = [];
    // Table Name
    protected $table = 'employer';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

}
