<?php

use Illuminate\Database\Seeder;

class UserAvailabilites extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'storage/databasefile/user_avilabilities.sql';
        DB::unprepared(file_get_contents($path));

    }
}
