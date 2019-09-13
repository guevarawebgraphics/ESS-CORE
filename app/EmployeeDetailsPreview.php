<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDetailsPreview extends Model
{
   //
   protected $guarded = [];
   // Table Name
   protected $table = 'employee_details_preview';
   // Primary Key
   public $primaryKey = 'id';
   // Timestamps
   public $timestamps = true;
}
