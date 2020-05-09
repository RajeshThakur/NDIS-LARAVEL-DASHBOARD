<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheet', function (Blueprint $table) {
            $table->increments('id');
 
            $table->integer('booking_order_id')->unsigned();
            $table->foreign('booking_order_id')->references('id')->on('booking_orders')->onDelete('cascade');
            $table->float('total_amount')->default(0)->comment('Provider amount: MaxItemRate*TimeInHrs');
            $table->float('payable_amount')->default(0)->comment('Support worker amount(without travel compensation): SWItemRate*TimeInHrs');
            $table->float('total_time')->default(0)->comment('Total booking time(hrs): EndTme-StartTime');
            $table->json('travel_compensation')->comment('Travel time and Rate');
            $table->boolean('is_billed')->default(0)->comment('Is this timesheet recored submitted ?');
            $table->dateTime('submitted_on')->comment('Datetime when this timesheet was submitted.');

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
        Schema::dropIfExists('timesheet');
    }
}
