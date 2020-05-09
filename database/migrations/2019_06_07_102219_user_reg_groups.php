<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRegGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reg_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('reg_group_id', false)->unsigned();
            $table->foreign('reg_group_id', 'user_reg_group_id_fk')->references('id')->on('registration_groups');
            
            $table->integer('user_id', false)->unsigned();
            $table->foreign('user_id', 'user_reg_user_id_fk')->references('id')->on('users');

            $table->integer('provider_id', false)->unsigned();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_reg_groups');
    }
}
