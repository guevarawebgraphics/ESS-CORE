<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Payrollregisterdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_register_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('PayRegisterId')->default('0');
            $table->bigInteger('account_id');
            $table->double('basic', 8, 2)->default('0');
            $table->double('absent')->default('0');
            $table->double('late')->default('0');
            $table->double('regular_ot')->default('0');
            $table->double('undertime')->default('0');
            $table->double('legal_holiday')->default('0');
            $table->double('special_holiday')->default('0');
            $table->double('night_differencial')->default('0');
            $table->double('adjustment_salary', 8, 2)->default('0');
            $table->double('night_diff_ot', 8, 2)->default('0');
            $table->double('incentives', 8, 2)->default('0');
            $table->double('commision', 8, 2)->default('0');
            $table->double('net_basic_taxable', 8, 2)->default('0');
            $table->double('non_taxable_allowance', 8 ,2)->default('0');
            $table->double('rice_allowance', 8 ,2)->default('0');
            $table->double('meal_allowance', 8 ,2)->default('0');
            $table->double('transpo', 8 ,2)->default('0');
            $table->double('ecola', 8 ,2)->default('0');
            $table->double('grosspay', 8 ,2)->default('0');
            $table->double('sss', 8 ,2)->default('0');
            $table->double('phic', 8 ,2)->default('0');
            $table->double('hdmf', 8 ,2)->default('0');
            $table->double('wtax', 8 ,2)->default('0');
            $table->double('sss_loan', 8 ,2)->default('0');
            $table->double('hdmf_load', 8 ,2)->default('0');
            $table->double('bank_loan', 8 ,2)->default('0');
            $table->double('cash_advance', 8 ,2)->default('0');
            $table->double('total_deduction', 8 ,2)->default('0');
            $table->double('net_pay', 8 ,2)->default('0');
            $table->double('bank_id', 8 ,2)->default('0');
            $table->string('account_no')->default('0');
            $table->dateTime('payroll_release_date');
            $table->double('overtime_hours', 8 ,2)->default('0');
            $table->double('absences_days')->default('0');
            $table->double('account_status', 8 ,2)->default('0');
            $table->dateTime('account_status_datetime');
            $table->dateTime('created_at');
            $table->bigInteger('created_by');
            $table->dateTime('created_datetime');
            $table->dateTime('updated_at');
            $table->dateTime('updated_datetime');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_register_details');
    }
}
