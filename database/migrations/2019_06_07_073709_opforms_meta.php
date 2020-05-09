<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OpformsMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opforms_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('opform_id', false)->unsigned();
            $table->foreign('opform_id', 'opforms_opform_id_fk')->references('id')->on('opforms');
            $table->string('meta_key');
            $table->longText('meta_value');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opforms_meta');
    }
}
