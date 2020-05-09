<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProviderRegGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_reg_groups', function (Blueprint $table) { 
            $table->integer('user_id', false)->unsigned();
            $table->integer('state_id', false)->unsigned();
            $table->integer('parent_reg_group_id', false)->unsigned();
            $table->integer('reg_group_id', false)->unsigned();
            $table->enum('inhouse',  [0, 1] )->default(1);
            $table->float('cost')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_reg_groups');
    }
}
