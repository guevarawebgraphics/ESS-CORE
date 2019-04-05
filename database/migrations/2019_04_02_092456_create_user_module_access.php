<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserModuleAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_module_access', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_type_id');
            $table->string('my_profile');
            $table->string('create_profile');
            $table->string('manage_users');
            $table->string('ess_content');
            $table->string('send_announcement');
            $table->string('manage_docs');
            $table->string('employee_enrollment');
            $table->string('payroll_management');
            $table->string('employer_content');
            $table->string('payslips');
            $table->string('t_a');
            $table->string('icredit');
            $table->string('cash_advance');
            $table->string('e_wallet');
            $table->string('financial_calendar');
            $table->string('financial_tips');
            $table->integer('deleted');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_module_access');
    }
}
