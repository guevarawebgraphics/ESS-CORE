<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeePersonalInformationPreviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_personal_information_preview', function (Blueprint $table) {
            $table->bigIncrements('id');
            //first column
           
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('TIN');
            $table->string('SSSGSIS');
            $table->string('PHIC');
            $table->string('HDMF');
            $table->string('NID');
            
            $table->string('mobile_no');
            $table->string('email_add');
           
            $table->date('birthdate');
            $table->string('gender');
            $table->string('civil_status');

            //address field
            $table->string('country');
            $table->string('address_unit');
            $table->string('citytown');
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
        Schema::dropIfExists('employee_personal_information_preview');
    }
}
