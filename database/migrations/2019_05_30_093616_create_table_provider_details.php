<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProviderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_details', function (Blueprint $table) {
            $table->integer('user_id', false)->unsigned();
            $table->integer('organisation_id', false)->unsigned();
            $table->string('ra_number');
            $table->date('renewal_date');
            $table->string('ndis_cert', false);
            $table->unsignedTinyInteger('is_onboarding_complete')->default(0);
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
        Schema::dropIfExists('provider_details');
    }
}
