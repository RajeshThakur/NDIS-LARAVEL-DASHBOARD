<?php

use Illuminate\Database\Seeder;
use App\ContentPage;

class ContentPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $templates = [
            [
                'id'         => 1,
                'title'      => 'policies',
                'slug'       => 'policies',
                'page_text'  => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'excerpt'    => 'policies',
                'created_at' => '2019-05-09 13:26:39',
                'updated_at' => '2019-05-09 13:26:39'
            ],
            [
                'id'         => 2,
                'title'       => 'Self Audit',
                'slug'       => 'self-audit',
                'page_text'  => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'excerpt'    => 'selft',
                'created_at' => '2019-05-09 13:26:39',
                'updated_at' => '2019-05-09 13:26:39'
            ],
            [
                'id'         => 3,
                'title'       => 'Past Audit',
                'slug'       => 'past-audit',
                'page_text'  => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'excerpt'    => 'past',
                'created_at' => '2019-05-09 13:26:39',
                'updated_at' => '2019-05-09 13:26:39'
            ],
            [
                'id'         => 4,
                'title'       => 'Tutorials and help',
                'slug'       => 'tutorials-and-help',
                'page_text'  => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'excerpt'    => 'tutorials',
                'created_at' => '2019-05-09 13:26:39',
                'updated_at' => '2019-05-09 13:26:39'
            ],
        ];

        ContentPage::insert($templates);

    }
}
