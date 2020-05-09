<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
                    [                        
                        'full_name'     => 'New South Wales',                        
                        'short_name'     => 'NSW',                        
                    ],
                    [                        
                        'full_name'     => 'Victoria',                        
                        'short_name'     => 'VIC',                        
                    ],
                    [                        
                        'full_name'     => 'Queensland',                        
                        'short_name'     => 'QLD',                        
                    ],
                    [                        
                        'full_name'     => 'Tasmania',                        
                        'short_name'     => 'TAS',                        
                    ],
                    [                        
                        'full_name'     => 'South Australia',                        
                        'short_name'     => 'SA',                        
                    ],
                    [                        
                        'full_name'     => 'Western Australia',                        
                        'short_name'     => 'WA',                        
                    ],
                    [                        
                        'full_name'     => 'Northern Territory',                        
                        'short_name'     => 'NT',                        
                    ],
                    [                        
                        'full_name'     => 'Australian Capital Territory',                        
                        'short_name'     => 'ACT',                        
                    ],
        ];

        DB::table('states')->insert($states);
    }
}
