<?php

use Illuminate\Database\Seeder;
use App\Colors;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            [
                'id'         => '1',
                'name'       => 'Aqua',
                'color'      => 'aqua',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '2',
                'name'       => 'Black',
                'color'       => 'black',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '3',
                'name'       => 'Blue',
                'color'       => 'blue',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '4',
                'name'       => 'Brown',
                'color'       => 'brown',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '5',
                'name'       => 'Cyan',
                'color'       => 'cyan',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '6',
                'name'       => 'Gray',
                'color'       => 'gray',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '7',
                'name'       => 'Green',
                'color'       => 'green',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '8',
                'name'       => 'Maroon',
                'color'       => 'maroon',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '9',
                'name'       => 'Navy',
                'color'       => 'navy',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '10',
                'name'       => 'Orange',
                'color'       => 'orange',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '11',
                'name'       => 'Pink',
                'color'       => 'pink',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '12',
                'name'       => 'Red',
                'color'       => 'red',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '13',
                'name'       => 'Yellow',
                'color'       => 'yellow',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '14',
                'name'       => 'Violet',
                'color'       => 'violet',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
        ];

        Colors::insert($colors);
    }
}
