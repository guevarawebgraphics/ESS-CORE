<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameHdmfLoadInPayrollRegisterDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_register_details', function (Blueprint $table) {
            $table->renameColumn('hdmf_load', 'hdmf_loan');
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
            $table->dropColumn('hdmf_load', 'hdmf_loan');
        });
    }
}
