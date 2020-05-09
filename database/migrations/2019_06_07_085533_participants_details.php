<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParticipantsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false)->unsigned();
            $table->string('address');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->date('start_date_ndis');
            $table->date('end_date_ndis');
            $table->string('ndis_number');
            $table->string('participant_goals')->nullable();
            $table->longText('special_requirements')->nullable();
            $table->float('budget_funding')->default(0);
            $table->float('funds_balance', 12, 2)->default(0);
            $table->unsignedTinyInteger('have_gps_phone')->default(1);
            $table->unsignedTinyInteger('using_guardian')->default(0);
            $table->integer('guardian_id', false)->unsigned()->default(0);;
            $table->unsignedTinyInteger('agreement_signed')->default(0);
            $table->unsignedTinyInteger('onboarding_step')->default(1);
            $table->unsignedTinyInteger('is_onboarding_complete')->default(0);

            $table->timestamps();
            $table->softDeletes();

        });

        Schema::table('participants_details', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants_details', function($table)
        {
            // drop foreign key ({tablename}_{foreign_key_name}_foreign)
            $table->dropForeign('participants_details_user_id_foreign');
        });
        Schema::dropIfExists('participants_details');
    }
}
