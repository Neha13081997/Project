<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          # Backend
        //'role_edit', 'role_show', 'role_access', 'profile_access', 'profile_edit', 'change_password',  'staff_access', 'staff_create', 'staff_edit', 'staff_delete', 'setting_access', 'setting_edit'

        # Frontend
        // 'profile_access', 'profile_edit' , 'change_password', 'post_create', 'post_edit', 'post_delete', 'post_access' 

        $roles = Role::all();
        
        $admin_permission_ids = Permission::all();

        $staff_permission_ids = Permission::whereIn('name',['profile_access', 'profile_edit' , 'change_password'])->where('type','backend')->pluck('id')->toArray();

        $coustomer_permission_ids = Permission::whereNotIn('name',['profile_access', 'profile_edit' , 'change_password', 'post_create', 'post_edit', 'post_delete', 'post_access', 'post_view'])->where('type','frontend')->pluck('id')->toArray();

        foreach ($roles as $role) {
            switch ($role->id) {
                case 1:
                    $role->permissions()->sync($admin_permission_ids);
                    break;
                case 2:
                    $role->permissions()->sync($staff_permission_ids);
                    break;
                case 3:
                    $role->permissions()->sync($coustomer_permission_ids);
                    break;
                default:
                    break;
            }
        }
    }
}
