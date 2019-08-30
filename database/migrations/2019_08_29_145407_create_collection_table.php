<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('collection_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->integer('employee_id')->unsinged();
            $table->string('collection_cash_source');
            $table->decimal('collection_amount', 8, 2)->unsigned();
            $table->date('collection_date');
            $table->string('collection_theme_color');
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
        Schema::dropIfExists('collection');
    }
}
