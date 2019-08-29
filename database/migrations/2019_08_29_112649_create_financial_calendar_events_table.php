<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialCalendarEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_calendar_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('calendar_event_id')->unsinged();
            $table->integer('created_by')->unsinged();
            $table->integer('updated_by')->unsinged();
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
        Schema::dropIfExists('financial_calendar_events');
    }
}
