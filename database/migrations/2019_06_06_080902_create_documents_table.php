<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('collection_name', 100)->nullable();
            $table->string('mime_type', 50)->nullable();
            $table->string('local_path', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->integer('size', false)->unsigned()->default(0);
            $table->string('s3_bucket')->nullable();
            $table->string('s3_key', 255)->nullable();
            $table->integer('user_id', false)->unsigned()->index();
            $table->integer('provider_id', false)->unsigned()->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
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
        Schema::dropIfExists('documents');
    }
}
