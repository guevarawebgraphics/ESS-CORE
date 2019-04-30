<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployerContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employercontent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id')->unsigned();
            $table->string('content_title');
            $table->string('content_description');
            $table->integer('content_status')->unsigned();
            $table->integer('content_type')->unsigned();
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
        Schema::dropIfExists('employercontent');
    }
}
