<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create1557408399717PermissionRolePivotTable extends Migration
{
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->foreign('role_id', 'role_id_fk_45955')->references('id')->on('roles');
            $table->unsignedInteger('permission_id');
            $table->foreign('permission_id', 'permission_id_fk_45955')->references('id')->on('permissions');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permission_role');
    }
}
