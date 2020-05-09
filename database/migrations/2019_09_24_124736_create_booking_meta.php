<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_meta', function (Blueprint $table) {
            $table->bigIncrements('id');

            // $table->integer('booking_id')->unsigned();
            // $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');

            $table->integer('booking_order_id')->unsigned();
            $table->foreign('booking_order_id')->references('id')->on('booking_orders')->onDelete('cascade');

            $table->string('meta_key')->default('')->comment('Meta key to store extra booking info title');
            $table->longText('meta_value')->default('')->comment('Meta value to store extra booking info data');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_meta');
    }
}
