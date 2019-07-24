<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployerIdToUserPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_picture', function (Blueprint $table) {
            $table->integer('employer_id')->after('user_id')->default('0')->unsinged();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_picture', function (Blueprint $table) {
            $table->dropColumn('employer_id')->after('user_id')->default('0')->unsinged();
        });
    }
}
