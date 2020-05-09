<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParticipantsRegGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants_reg_groups', function (Blueprint $table) {
            $table->integer('reg_group_id', false)->unsigned();
            $table->foreign('reg_group_id', 'participant_reg_group_id_fk')->references('id')->on('registration_groups');
            
            $table->integer('user_id', false)->unsigned();
            $table->foreign('user_id', 'participant_id_user_id_fk')->references('id')->on('users');

            $table->integer('provider_id', false)->unsigned();

            $table->unsignedDecimal('budget', 12, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants_reg_groups');
    }
}
