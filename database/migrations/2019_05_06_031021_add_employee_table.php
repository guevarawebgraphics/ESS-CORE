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
            $table->integer('account_id')->unsigned();
            $table->string('employee_no');
            $table->string('position');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('TIN');
            $table->string('SSS/GSIS');
            $table->string('PHIC');
            $table->string('HDMF');
            $table->string('NID');
            $table->string('payroll_bank');
            //second column
            $table->string('employer_id');
            $table->string('department');
            $table->string('mobile_no');
            $table->string('email_add');
            $table->date('enrollment_date');
            $table->string('employment_status');
            $table->date('birthdate');
            $table->string('gender');
            $table->string('civil_status');
            $table->string('payroll_schedule');
            $table->string('account_no');

            //address field
            $table->string('country');
            $table->string('address_unit');
            $table->string('city/town');
            $table->string('barangay');
            $table->string('province');
            $table->string('zipcode');

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
