<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeInfoToEssBasetable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ess_basetable', function (Blueprint $table) {
            $table->string('employee_info')->after('employee_no')->default('none');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ess_basetable', function (Blueprint $table) {
            $table->dropColumn('employee_info')->after('employee_no')->default('none');
        });
    }
}
