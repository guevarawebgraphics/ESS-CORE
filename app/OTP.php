<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $guarded = [];
    // Table Name
    protected $table = 'otp';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
 
}
