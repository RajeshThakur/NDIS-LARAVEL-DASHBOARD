<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgreementSignedFieldToServiceProviderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_provider_details', function (Blueprint $table) {
            $table->unsignedTinyInteger('agreement_signed')->default(0)->after('lng');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_provider_details', function (Blueprint $table) {
            $table->dropColumn(['agreement_signed']);
        });
    }
}
