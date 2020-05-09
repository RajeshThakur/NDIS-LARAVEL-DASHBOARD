<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            RegistrationGroupSeeder::class,
            StatesTableSeeder::class,
            OpformTemplateSeeder::class,
            ContentCategorySeeder::class,
            ContentTagSeeder::class,
            ContentPageSeeder::class,
            ContentCategoryTagSeeder::class,
            TaskStatusTableSeeder::class,
            TaskTagTableSeeder::class,
            UserAvailabilites::class,
            ColorSeeder::class,
        ]);
    }
}
