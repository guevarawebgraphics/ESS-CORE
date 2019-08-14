<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('read_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('employer_content_id')->unsigned();
            $table->integer('action_taken')->unsigned();
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
        Schema::dropIfExists('read_status');
    }
}
