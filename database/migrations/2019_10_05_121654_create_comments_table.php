<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->UnsignedInteger('relatation_id')->default(0);
            $table->ipAddress('author_ip');
            $table->longText('content');
            $table->tinyInteger('approved')->default(1);
            $table->string('type',30)->default('incident');
            $table->bigInteger('parent')->default(0);
            $table->UnsignedInteger('user_id');

            $table->foreign('user_id', 'icomment_user_id_fk')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
