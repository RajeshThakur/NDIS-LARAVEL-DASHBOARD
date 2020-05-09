<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        
        // $user_permissions = $admin_permissions->filter(function ($permission) {
        //     return substr($permission->title, 0, 5) != 'user_' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        // });

        $user_permissions = \App\Permission::all()->filter(function ($permission) {

            return substr($permission->title, 0, 16) == 'service_booking_'
                    // || in_array($permission->title,[ 'task_management_access', 'task_create', 'task_edit', 'task_show', 'task_delete', 'task_access', 'tasks_calendar_access' ])
                    || in_array($permission->title, [  'task_create', 'task_edit', 'task_show', 'task_delete', 'task_access','message_create','message_edit','message_show','message_delete','message_access','reports_access','reports_create','reports_edit','reports_show','reports_delete','external_service_provider_access','external_service_provider_delete','external_service_provider_show','external_service_provider_edit','external_service_provider_create','accounts_access'
                         ])
                    // || substr($permission->title, 0, 5) == 'task_'
                    // || substr($permission->title, 0, 17) == 'external_service_' 
                    // || substr($permission->title, 0, 16) == 'operation_forms_' 
                    // || substr($permission->title, 0, 19) == 'registration_group_'
                    || substr($permission->title, 0, 15) == 'support_worker_'  
                    || $permission->title == 'user_profile'
                    || substr($permission->title, 0, 12) == 'participant_'
                    || substr($permission->title, 0, 14)  == 'content_page_a'
                    || substr($permission->title, 0, 17)  == 'content_page_show';
            
        });
        
        Role::findOrFail(2)->permissions()->sync($user_permissions);


        $participant_permissions = \App\Permission::all()->filter(function ($permission) {

            return in_array($permission->title, [  'task_show','task_access','message_create','message_show','message_access','message_edit'
                         ]);
        });
        
        Role::findOrFail(3)->permissions()->sync($participant_permissions);
    }
}