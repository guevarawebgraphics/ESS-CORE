<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployerIdToPayrollregister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrollregister', function (Blueprint $table) {
            $table->integer('employer_id')->after('account_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payrollregister', function (Blueprint $table) {
            $table->dropColumn('employer_id')->after('account_id')->unsigned();
        });
    }
}
