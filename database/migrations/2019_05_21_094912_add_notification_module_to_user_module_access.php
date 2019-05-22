<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationModuleToUserModuleAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_module_access', function (Blueprint $table) {
            $table->string('system_notifications')->after('ess_content')->default('none');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_module_access', function (Blueprint $table) {
            $table->dropColumn('system_notifications')->after('ess_content')->default('none');
        });
    }
}
