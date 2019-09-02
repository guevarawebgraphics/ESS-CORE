<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('payment_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->integer('employee_id')->unsinged();
            $table->string('payment_source');
            $table->decimal('payment_amount', 8, 2)->unsigned();
            $table->date('payment_date');
            $table->string('payment_theme_color');
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
            Schema::table('payment', function (Blueprint $table) {
                Schema::dropIfExists('payment');
            });
    }
}
