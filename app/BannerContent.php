<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerContent extends Model
{
     //
     protected $guarded = [];
     // Table Name
     protected $table = 'banner';
     // Primary Key
     public $primaryKey = 'id';
     // Timestamps
     public $timestamps = true;
}
