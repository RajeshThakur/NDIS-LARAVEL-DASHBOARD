<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_complaints', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('booking_order_id')->nullable(); // Incident for Service booking ID

            $table->text('complaint_details')->nullable();
           
            $table->foreign('booking_order_id', 'complaint_booking_order_id_fk')->references('id')->on('booking_orders');

            $table->unsignedInteger('user_id')->nullable(); // Incident Report against User

            $table->unsignedInteger('provider_id')->nullable(); // Related to the Provider

            $table->unsignedInteger('created_by')->nullable(); // Incident Report by the User

            $table->foreign('created_by', 'booking_complaint_created_by_fk')->references('id')->on('users');
            

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
        Schema::dropIfExists('booking_complaints');
    }
}
