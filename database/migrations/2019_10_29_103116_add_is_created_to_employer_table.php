<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsCreatedToEmployerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employer', function (Blueprint $table) {
            $table->integer('iscreated')->after('email_verified_at')->default("0"); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employer', function (Blueprint $table) {
            $table->dropColumn('iscreated');
        });
    }
}
