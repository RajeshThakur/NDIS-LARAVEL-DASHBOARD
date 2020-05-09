<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdaTimesheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proda_timesheet', function (Blueprint $table) {
            
            $table->integer('proda_id')->unsigned();
            $table->integer('timesheet_id')->unsigned();
            $table->foreign('proda_id')->references('id')->on('proda')
                ->onDelete('cascade');
            $table->foreign('timesheet_id')->references('id')->on('timesheet')
                ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proda_timesheet');
    }
}
