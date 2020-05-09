<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create1557410955294RegistrationGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('registration_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('item_number')->default(0);
            $table->integer('parent_id')->unsigned()->default(0);
            $table->enum('status',  [0, 1])->default(1);
            $table->string('unit')->default(0);
            $table->string('price_controlled')->default(0);
            $table->string('quote_required')->default(1);            
            $table->float('price_limit')->default(0);
            $table->enum('travel',[0, 1])->default(0);
            $table->enum('cancellations',[0, 1])->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('registration_groups');
    }
}