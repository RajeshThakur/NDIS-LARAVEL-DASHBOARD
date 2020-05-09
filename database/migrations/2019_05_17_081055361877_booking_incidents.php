<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookingIncidents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_incidents', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('booking_order_id')->nullable(); // Incident for Service booking ID
            $table->dateTime('datetime')->nullable();
            $table->text('incident_details')->nullable();
            $table->text('any_injuries')->nullable();
            $table->text('any_damage')->nullable();
            $table->text('cause_of_incident')->nullable();
            $table->text('actions_to_eliminate')->nullable();
            $table->text('management_comments')->nullable();

            $table->string('management_sign')->nullable();
            $table->date('date_of_sign')->nullable();

            $table->foreign('booking_order_id', 'incident_booking_order_id_fk')->references('id')->on('booking_orders');

            $table->unsignedInteger('user_id')->nullable(); // Incident Report against User

            $table->unsignedInteger('provider_id')->nullable(); // Related to the Provider

            $table->unsignedInteger('created_by')->nullable(); // Incident Report by the User
            $table->foreign('created_by', 'booking_incidents_created_by_fk')->references('id')->on('users');
            

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
        Schema::dropIfExists('booking_incidents');
    }
}
