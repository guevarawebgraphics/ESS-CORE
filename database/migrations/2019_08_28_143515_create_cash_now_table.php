<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashNowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_now', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cash_now_id')->unsinged();
            $table->integer('account_id')->unsinged();
            $table->integer('employee_id')->unsinged();
            $table->decimal('cash_now_amount', 8, 2)->unsinged();
            $table->string('cash_now_description');
            $table->date('cash_now_date');
            $table->string('cash_now_theme_color');
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
        Schema::dropIfExists('cash_now');
    }
}
