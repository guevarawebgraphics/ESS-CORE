<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDoubleToDecimalPayrollRegisterDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_register_details', function (Blueprint $table) {
            $table->decimal('basic')->change();
            $table->decimal('absent')->change();
            $table->decimal('late')->change();
            $table->decimal('regular_ot')->change();
            $table->decimal('undertime')->change();
            $table->decimal('legal_holiday')->change();
            $table->decimal('special_holiday')->change();
            $table->decimal('night_differencial')->change();
            $table->decimal('adjustment_salary', 8, 2)->change();
            $table->decimal('night_diff_ot', 8, 2)->change();
            $table->decimal('incentives', 8, 2)->change();
            $table->decimal('commision', 8, 2)->change();
            $table->decimal('net_basic_taxable', 8, 2)->change();
            $table->decimal('non_taxable_allowance', 8 ,2)->change();
            $table->decimal('rice_allowance', 8 ,2)->change();
            $table->decimal('meal_allowance', 8 ,2)->change();
            $table->decimal('telecom', 8 ,2)->change();
            $table->decimal('transpo', 8 ,2)->change();
            $table->decimal('ecola', 8 ,2)->change();
            $table->decimal('grosspay', 8 ,2)->change();
            $table->decimal('sss', 8 ,2)->change();
            $table->decimal('phic', 8 ,2)->change();
            $table->decimal('hdmf', 8 ,2)->change();
            $table->decimal('wtax', 8 ,2)->change();
            $table->decimal('sss_loan', 8 ,2)->change();
            $table->decimal('hdmf_loan', 8 ,2)->change();
            $table->decimal('bank_loan', 8 ,2)->change();
            $table->decimal('cash_advance', 8 ,2)->change();
            $table->decimal('total_deduction', 8 ,2)->change();
            $table->decimal('net_pay', 8 ,2)->change();
            $table->decimal('bank_id', 8 ,2)->change();
            $table->decimal('overtime_hours', 8 ,2)->change();
            $table->decimal('absences_days')->change();
            $table->integer('account_status')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_register_details', function (Blueprint $table) {
            $table->dropColumn('basic')->change();
            $table->dropColumn('absent')->change();
            $table->dropColumn('late')->change();
            $table->dropColumn('regular_ot')->change();
            $table->dropColumn('undertime')->change();
            $table->dropColumn('legal_holiday')->change();
            $table->dropColumn('special_holiday')->change();
            $table->dropColumn('night_differencial')->change();
            $table->dropColumn('adjustment_salary', 8, 2)->change();
            $table->dropColumn('night_diff_ot', 8, 2)->change();
            $table->dropColumn('incentives', 8, 2)->change();
            $table->dropColumn('commision', 8, 2)->change();
            $table->dropColumn('net_basic_taxable', 8, 2)->change();
            $table->dropColumn('non_taxable_allowance', 8 ,2)->change();
            $table->dropColumn('rice_allowance', 8 ,2)->change();
            $table->dropColumn('meal_allowance', 8 ,2)->change();
            $table->dropColumn('telecom', 8 ,2)->change();
            $table->dropColumn('transpo', 8 ,2)->change();
            $table->dropColumn('ecola', 8 ,2)->change();
            $table->dropColumn('grosspay', 8 ,2)->change();
            $table->dropColumn('sss', 8 ,2)->change();
            $table->dropColumn('phic', 8 ,2)->change();
            $table->dropColumn('hdmf', 8 ,2)->change();
            $table->dropColumn('wtax', 8 ,2)->change();
            $table->dropColumn('sss_loan', 8 ,2)->change();
            $table->dropColumn('hdmf_loan', 8 ,2)->change();
            $table->dropColumn('bank_loan', 8 ,2)->change();
            $table->dropColumn('cash_advance', 8 ,2)->change();
            $table->dropColumn('total_deduction', 8 ,2)->change();
            $table->dropColumn('net_pay', 8 ,2)->change();
            $table->dropColumn('bank_id', 8 ,2)->change();
            $table->dropColumn('overtime_hours', 8 ,2)->change();
            $table->dropColumn('absences_days')->change();
            $table->dropColumn('account_status')->change();
        });
    }
}
