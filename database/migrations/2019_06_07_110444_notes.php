<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('notes', function (Blueprint $table) {

            $table->increments('id');
            
            $table->string('title');
            
            $table->mediumText('description');
            
            $table->enum('type',  ['support_worker', 'participant', 'booking'] )->default('participant');

            $table->unsignedInteger('relation_id')->nullable(); //Notes made for Participant / Support Worker / Bookings ( ID )

            $table->unsignedInteger('provider_id')->nullable(); // Related to the Provider
            $table->foreign('provider_id', 'notes_provider_id_fk')->references('id')->on('users');

            $table->unsignedInteger('created_by')->nullable(); // Notes made by the User
            $table->foreign('created_by', 'notes_created_by_fk')->references('id')->on('users');
            
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
        Schema::dropIfExists('notes');
    }
}
