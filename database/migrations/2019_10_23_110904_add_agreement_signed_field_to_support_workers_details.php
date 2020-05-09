<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgreementSignedFieldToSupportWorkersDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('support_workers_details', function (Blueprint $table) {
            $table->unsignedTinyInteger('agreement_signed')->default(0)->after('onboarding_step');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('support_workers_details', function (Blueprint $table) {
            $table->dropColumn(['agreement_signed']);
        });
    }
}