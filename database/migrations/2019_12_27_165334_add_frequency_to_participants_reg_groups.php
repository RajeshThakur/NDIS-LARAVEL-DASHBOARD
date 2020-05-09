<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFrequencyToParticipantsRegGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants_reg_groups', function (Blueprint $table) {
            //
            $table->string('frequency',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants_reg_groups', function (Blueprint $table) {
            //
            $table->dropColumn(['frequency']);
        });
    }
}
