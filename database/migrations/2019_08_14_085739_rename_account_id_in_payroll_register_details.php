<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAccountIdInPayrollRegisterDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_register_details', function (Blueprint $table) {
            $table->renameColumn('account_id', 'employee_no');
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
            $table->dropColumn('account_id', 'employee_no');
        });
    }
}
