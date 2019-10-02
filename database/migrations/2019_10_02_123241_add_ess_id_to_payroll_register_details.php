<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEssIdToPayrollRegisterDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_register_details', function (Blueprint $table) {
            $table->string('ess_id')->after('employee_no');
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
            $table->dropColumn('ess_id')->after('employee_no');
        });
    }
}
