<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParticipantsGuardianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants_guardian', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('lat');
            $table->string('lng');
            $table->string('phone')->nullable();;
            $table->string('mobile')->nullable();;
            $table->string('email');
            $table->datetime('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('user_id', false)->unsigned();
            $table->foreign('user_id', 'guardians_user_id_fk')->references('id')->on('users');
            $table->string('token')->nullable();
            $table->tinyInteger('active')->default(0);
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
        Schema::dropIfExists('participants_guardian');
    }
}
