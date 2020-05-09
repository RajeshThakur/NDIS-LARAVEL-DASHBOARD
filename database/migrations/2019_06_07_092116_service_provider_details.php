<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServiceProviderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('service_provider_details')) {
            Schema::create('service_provider_details', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id', false)->unsigned();
                $table->foreign('user_id', 'service_provider_user_id_fk')->references('id')->on('users');

                $table->string('address')->nullable();
                $table->string('lat')->nullable();
                $table->string('lng')->nullable();
                
                $table->string('service_provided', 255)->nullable();
                //$table->unsignedTinyInteger('agreement_signed')->default(0);
                $table->unsignedTinyInteger('is_onboarding_complete')->default(0);
                $table->unsignedTinyInteger('onboarding_step')->default(1);
                $table->timestamps();

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_provider_details');
    }


}