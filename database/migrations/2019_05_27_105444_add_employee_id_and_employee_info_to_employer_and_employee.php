<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeIdAndEmployeeInfoToEmployerAndEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employer_and_employee', function (Blueprint $table) {
            $table->integer('employee_id')->after('employee_no')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employer_and_employee', function (Blueprint $table) {
            $table->dropColumn('employee_id')->after('employee_no')->unsigned();
        });
    }
}
