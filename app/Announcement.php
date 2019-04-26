<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    //
    protected $guarded = [];
    // Table Name
    protected $table = 'announcement';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

}
