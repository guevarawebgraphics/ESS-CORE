<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSuffixToEmployeePersonalInformationPreviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_personal_information_preview', function (Blueprint $table) {
            $table->string('suffix')->after('middlename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_personal_information_preview', function (Blueprint $table) {
            //
        });
    }
}
