<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $updateDate = $createDate = date('Y-m-d H:i:s');
        $permissions = [
            [
                'name'       => 'role_access',
                'title'      => 'Menu Access',
                'route_name' => 'roles',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'role_edit',
                'title'      => 'Edit',
                'route_name' =>'roles',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'role_show',
                'title'      => 'View',
                'route_name' => 'roles',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'profile_access',
                'title'      => 'View',
                'route_name' => 'profile',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'profile_edit',
                'title'      => 'Edit',
                'route_name' => 'profile',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'change_password',
                'title'      => 'Change Password',
                'route_name' => 'profile',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            
            [
                'name'       => 'staff_access',
                'title'      => 'Menu Access',
                'route_name' => 'staff',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'staff_create',
                'title'      => 'Add',
                'route_name' => 'staff',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'staff_edit',
                'title'      => 'Edit',
                'route_name' => 'staff',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'staff_view',
                'title'      => 'View',
                'route_name' => 'staffs',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'staff_delete',
                'title'      => 'Delete',
                'route_name' => 'staff',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            
            [
                'name'       => 'setting_access',
                'title'      => 'Setting Menu Access',
                'route_name' => 'settings',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'setting_edit',
                'title'      => 'Edit',
                'route_name' => 'settings',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],


            [
                'name'       => 'coustomer_access',
                'title'      => 'Menu Access',
                'route_name' => 'coustomers',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'coustomer_create',
                'title'      => 'Add',
                'route_name' => 'coustomers',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'coustomer_edit',
                'title'      => 'Edit',
                'route_name' => 'coustomers',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'coustomer_view',
                'title'      => 'View',
                'route_name' => 'coustomers',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'coustomer_delete',
                'title'      => 'Delete',
                'route_name' => 'coustomers',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            


            //Frontend
            [
                'name'       => 'profile_access',
                'title'      => 'View',
                'route_name' => 'profile',
                'type'       => 'frontend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'profile_edit',
                'title'      => 'Edit',
                'route_name' => 'profile',
                'type'       => 'frontend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'change_password',
                'title'      => 'Change Password',
                'route_name' => 'profile',
                'type'       => 'frontend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'       => 'post_access',
                'title'      => 'Menu Access',
                'route_name' => 'posts',
                'type'       => 'frontend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'post_create',
                'title'      => 'Add',
                'route_name' => 'posts',
                'type'       => 'frontend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'post_edit',
                'title'      => 'Edit',
                'route_name' => 'posts',
                'type'       => 'frontend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'post_view',
                'title'      => 'View',
                'route_name' => 'posts',
                'type'       => 'frontend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'post_delete',
                'title'      => 'Delete',
                'route_name' => 'posts',
                'type'       => 'frontend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],          

        ];
        Permission::insert($permissions);
    }
}
