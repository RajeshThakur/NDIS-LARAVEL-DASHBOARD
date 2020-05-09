<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SupportWorkerDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('support_workers_details')) {
            Schema::create('support_workers_details', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id', false)->unsigned();
                $table->foreign('user_id', 'support_workers_user_id_fk')->references('id')->on('users');

                $table->string('address')->nullable();
                $table->string('lat')->nullable();
                $table->string('lng')->nullable();
                
                //$table->unsignedTinyInteger('agreement_signed')->default(0);
                $table->unsignedTinyInteger('is_onboarding_complete')->default(0);
                $table->unsignedTinyInteger('onboarding_step')->default(1);

                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('support_workers_details');
    }
}
