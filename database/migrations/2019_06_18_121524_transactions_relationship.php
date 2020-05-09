<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransactionsRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions_relationship', function (Blueprint $table) {
            $table->integer('trans_id', false)->unsigned();
            $table->integer('user_id', false)->unsigned();
            $table->integer('provider_id', false)->unsigned();
            

        });

        Schema::table('transactions_relationship', function($table) {
            $table->foreign('trans_id', 'transactions_relationship_trans_id_foreign')->references('id')->on('transactions');
            $table->foreign('user_id', 'transactions_relationship_user_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions_relationship', function($table)
        {
            // drop foreign key ({tablename}_{foreign_key_name}_foreign)
            $table->dropForeign('transactions_relationship_trans_id_foreign');
            $table->dropForeign('transactions_relationship_user_id_foreign');
        });
        Schema::dropIfExists('transactions_relationship');
    }
}
