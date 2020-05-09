<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_checkouts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('booking_order_id', false)->unsigned();
            // $table->foreign('booking_order_id', 'bookings_booking_order_id_fk')->references('id')->on('booking_orders');


            $table->boolean('participant_checkout')->default(0);
            $table->dateTime('participant_checkout_time')->nullable();
            $table->string('participant_lat')->nullable();
            $table->string('participant_lng')->nullable();

            $table->boolean('sw_checkout')->default(0);
            $table->dateTime('sw_checkout_time')->nullable();
            $table->string('sw_lat')->nullable();
            $table->string('sw_lng')->nullable();


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
        Schema::dropIfExists('booking_checkouts');
    }
}
