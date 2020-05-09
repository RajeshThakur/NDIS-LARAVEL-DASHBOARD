<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create1557408851776TasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->longText('description')->nullable();

            $table->unsignedInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_46023')->references('id')->on('task_statuses');

            $table->date('due_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->string('location')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            
            $table->integer('color_id', false)->unsigned();

            $table->unsignedInteger('provider_id')->nullable();
            $table->unsignedInteger('created_by_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
