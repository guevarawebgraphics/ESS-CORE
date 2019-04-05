<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shortname');
            $table->string('accountname');
            $table->string('address_unit');
            $table->string('address_country');
            $table->string('address_region');
            $table->string('address_town');
            $table->string('address_cityprovince');
            $table->string('address_barangay');
            $table->integer('address_zipcode');
            $table->integer('contact_person');
            $table->integer('contact_phone');
            $table->string('contact_mobile');
            $table->string('contact_email');
            $table->string('tin');
            $table->string('sss');
            $table->string('phic');
            $table->string('hdmf');
            $table->string('nid');
            // $table->string('Created_by');
            // $table->timestamp('CreatedDatetime');
            // $table->string('Updated_by');
            // $table->timestamp('UpdatedDatetime');   
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
        Schema::dropIfExists('employer');
    }
}
