<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {

                $table->increments('id');

                $table->string('location');
                $table->string('lat')->nullable();
                $table->string('lng')->nullable();
                
                $table->unsignedInteger('item_number')->nullable();    // Item Number for Registration Group
                $table->foreign('item_number', 'bookings_item_number_fk')->references('id')->on('registration_groups');

                $table->enum('service_type', ['support_worker','external_service'] )->default('support_worker');
                
                $table->enum('is_recurring', [0,1] )->default('0');
                $table->enum('recurring_frequency', ['none','daily','weekly','fortnightly','monthly','yearly'] )->default('none')->comment("Possible values'none','daily','weekly','fortnightly','monthly','yearly'");
                $table->unsignedTinyInteger('recurring_num')->default(0);

                $table->unsignedInteger('provider_id')->nullable();
                $table->foreign('provider_id', 'serbookrelation_provider_id_fk')->references('id')->on('users');
                
                $table->unsignedInteger('participant_id')->nullable();
                $table->foreign('participant_id', 'serbookrelation_participant_id_fk')->references('id')->on('users');

                $table->unsignedInteger('supp_wrkr_ext_serv_id')->nullable();
                $table->foreign('supp_wrkr_ext_serv_id', 'serbookrelation_supp_wrkr_ext_serv_id_fk')->references('id')->on('users');
                
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }

    /**
     * Get jsonable column data type.
     *
     * @return string
     */
    protected function jsonable(): string
    {
        $driverName = DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME);
        $dbVersion = DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION);
        $isOldVersion = version_compare($dbVersion, '5.7.8', 'lt');

        return $driverName === 'mysql' && $isOldVersion ? 'text' : 'json';
    }

}
