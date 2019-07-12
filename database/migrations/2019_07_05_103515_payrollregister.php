<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Payrollregister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrollregister', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id')->unsinged();
            $table->dateTime('period_from');
            $table->dateTime('period_to');
            $table->bigInteger('payroll_schedule_id');
            $table->string('batch_no');
            $table->string('payroll_file');
            $table->bigInteger('account_status');
            $table->dateTime('account_status_date_time');
            $table->bigInteger('created_by');
            $table->dateTime('created_at');
            $table->bigInteger('updated_by');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Payrollregister');
    }
}
