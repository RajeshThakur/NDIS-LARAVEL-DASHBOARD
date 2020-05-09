<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookingOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_orders', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('booking_id', false)->unsigned();
            $table->foreign('booking_id', 'bookings_booking_id_fk')->references('id')->on('bookings');

            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->string('timezone')->nullable();

            $table->enum('is_billable', [0,1] )->default(0);

            $table->enum('is_cancelled', [0,1] )->default(0);
            $table->dateTime('cancelled_at')->nullable();

            // $table->float('amount')->default(0);

            $table->enum('booking_type', ['normal','travel','cancelled'] )->default('normal');
            // Booking Type is created under this table because it is possible that one of the occurances of the recurring bookings match up with creteria for travel bookings or can be cancelled

            // $table->enum('status', ['Scheduled','Pending','Cancelled','Completed','Billed','Started','Submitted'] )->default('Scheduled')->comment("Possible values 'Scheduled','Pending','Cancelled','Completed','Billed'");
            $table->enum('status', ['Scheduled','Cancelled','Started','Approved','NotSatisfied','Submitted','Paid','Pending'] )->default('Scheduled')
                ->comment("Possible values 'Scheduled','Cancelled','Started','Approved','NotSatisfied','Submitted','Paid','Pending' ");
            

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
        Schema::dropIfExists('booking_orders');
    }
}
