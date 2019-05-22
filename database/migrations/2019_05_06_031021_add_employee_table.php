<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            //first column
            $table->integer('employee_info');
            $table->string('employee_no');
            $table->string('position');

            $table->string('payroll_bank');
            //second column
            $table->string('employer_id');
            $table->string('department');
            
            $table->date('enrollment_date');
            $table->string('employment_status');
           
            $table->string('payroll_schedule');
            $table->string('account_no');

            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
