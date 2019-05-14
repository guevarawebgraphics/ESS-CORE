<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $guarded = [];
    // Table Name
    protected $table = 'user_activation';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
 
}
