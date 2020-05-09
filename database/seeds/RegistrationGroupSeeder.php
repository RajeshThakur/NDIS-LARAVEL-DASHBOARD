<?php

use Illuminate\Database\Seeder;
use App\RegistrationGroup;
use Illuminate\Support\Facades\DB; 

class RegistrationGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $path = 'storage/databasefile/registration_groups.sql';
        DB::unprepared(file_get_contents($path));
        DB::unprepared( file_get_contents( 'storage/databasefile/registration_groups.sql' ) );
        DB::unprepared( file_get_contents( 'storage/databasefile/provider_reg_groups.sql' ) );
        DB::unprepared( file_get_contents( 'storage/databasefile/participant_reg_groups.sql' ) );
        DB::unprepared( file_get_contents( 'storage/databasefile/user_reg_groups.sql' ) );

    }
}
