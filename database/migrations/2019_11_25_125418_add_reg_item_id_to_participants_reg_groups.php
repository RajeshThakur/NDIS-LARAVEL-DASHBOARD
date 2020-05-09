<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegItemIdToParticipantsRegGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants_reg_groups', function (Blueprint $table) {
            $table->unsignedInteger('reg_item_id')->nullable()->after('reg_group_id');
            $table->unsignedDecimal('monthly_budget', 12, 2)->nullable()->after('budget');
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
            $table->dropColumn(['reg_item_id']);
            $table->dropColumn(['monthly_budget']);
        });
    }
}
