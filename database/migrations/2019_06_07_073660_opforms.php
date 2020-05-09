<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Opforms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opforms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->date('date')->nullable();

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'opforms_user_id_fk')->references('id')->on('users');

            $table->unsignedInteger('provider_id')->nullable();
            $table->foreign('provider_id', 'opforms_provider_id_fk')->references('id')->on('users');

            $table->unsignedInteger('template_id')->nullable();
            $table->foreign('template_id', 'opforms_template_id_fk')->references('id')->on('opforms_templates');
            
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
        Schema::table('opforms', function($table)
        {
            $table->dropForeign('opforms_template_id_fk');
            $table->dropForeign('opforms_provider_id_fk');
            $table->dropForeign('opforms_user_id_fk');
        });
        Schema::dropIfExists('opforms');
    }
}
