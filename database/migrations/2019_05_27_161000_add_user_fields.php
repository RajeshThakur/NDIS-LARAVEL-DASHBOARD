<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name', 50)->after('first_name')->nullable();
            $table->string('mobile', 20)->after('email')->nullable();
            $table->integer('avatar')->after('mobile')->unsigned()->nullable();
            $table->string('token')->after('remember_token')->nullable();
            $table->string('push_token', 100)->after('token')->unique()->nullable()->default(null);
            $table->string('platform', 40)->after('push_token')->nullable()->default(null);
            $table->boolean('active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_name', 'mobile', 'avatar', 'token', 'active']);
        });
    }
}
