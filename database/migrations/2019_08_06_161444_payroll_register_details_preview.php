<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PayrollRegisterDetailsPreview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_register_details_preview', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('PayRegisterId')->default('0');
            $table->bigInteger('account_id');
            $table->float('basic', 8, 2)->default('0');
            $table->float('absent')->default('0');
            $table->float('late')->default('0');
            $table->float('regular_ot')->default('0');
            $table->float('undertime')->default('0');
            $table->float('legal_holiday')->default('0');
            $table->float('special_holiday')->default('0');
            $table->float('night_differencial')->default('0');
            $table->float('adjustment_salary', 8, 2)->default('0');
            $table->float('night_diff_ot', 8, 2)->default('0');
            $table->float('incentives', 8, 2)->default('0');
            $table->float('commision', 8, 2)->default('0');
            $table->float('net_basic_taxable', 8, 2)->default('0');
            $table->float('non_taxable_allowance', 8 ,2)->default('0');
            $table->float('rice_allowance', 8 ,2)->default('0');
            $table->float('meal_allowance', 8 ,2)->default('0');
            $table->float('telecom', 8 ,2)->default('0');
            $table->float('transpo', 8 ,2)->default('0');
            $table->float('ecola', 8 ,2)->default('0');
            $table->float('grosspay', 8 ,2)->default('0');
            $table->float('sss', 8 ,2)->default('0');
            $table->float('phic', 8 ,2)->default('0');
            $table->float('hdmf', 8 ,2)->default('0');
            $table->float('wtax', 8 ,2)->default('0');
            $table->float('sss_loan', 8 ,2)->default('0');
            $table->float('hdmf_loan', 8 ,2)->default('0');
            $table->float('bank_loan', 8 ,2)->default('0');
            $table->float('cash_advance', 8 ,2)->default('0');
            $table->float('total_deduction', 8 ,2)->default('0');
            $table->float('net_pay', 8 ,2)->default('0');
            $table->float('bank_id', 8 ,2)->default('0');
            $table->string('account_no')->default('0');
            $table->dateTime('payroll_release_date');
            $table->float('overtime_hours', 8 ,2)->default('0');
            $table->float('absences_days')->default('0');
            $table->float('account_status', 8 ,2)->default('0');
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
        Schema::dropIfExists('payroll_register_details_preview');
    }
}
