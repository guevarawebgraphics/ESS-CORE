<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeEmployerIdOnTableEssBasetable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ess_basetable', function (Blueprint $table) {          
            $table->string('employer_id')->after('account_id')->nullable()->default('none');
            $table->string('employee_no')->after('employer_id')->nullable()->default('none');
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
            $table->string('employer_id');
            $table->string('employee_no');
        });
    }
}
