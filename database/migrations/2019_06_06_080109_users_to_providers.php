<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersToProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_to_providers', function (Blueprint $table) {
            $table->integer('user_id', false)->unsigned();
            $table->integer('provider_id', false)->unsigned();
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
        Schema::table('users_to_providers', function (Blueprint $table) {
        });

        Schema::dropIfExists('users_to_providers');
    }
}
