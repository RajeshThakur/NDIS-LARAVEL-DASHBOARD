<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'user_availabilities', function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->morphs('user');
            $table->string('range');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->boolean('is_bookable')->default(false);
            $table->smallInteger('priority')->unsigned()->nullable();
            $table->integer('provider_id', false)->unsigned();
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
        Schema::dropIfExists( 'user_availabilities' );
    }
}
