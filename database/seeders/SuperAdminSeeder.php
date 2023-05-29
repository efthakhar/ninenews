<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    
    
    public function run(): void
    {
        Cache::flush();

        DB::table('users')->truncate();

        // seed super admin and get id
        $super_admin_id = DB::table('users')->insertGetId([
            'name' => 'superadmin',
            'email' => 'superadmin@ninenews.com',
            'password' => Hash::make('superadmin'),
        ]);

        // $role = Role::create(['name' => 'super-admin']);

        // // create roles // here super admin role
        // $super_admin_role_id = DB::table('roles')->where('name','=','super-admin')->value('id');
        // if($super_admin_role_id===NULL)
        // {
        //     $super_admin_role_id = DB::table('roles')->insertGetId([            
        //         'name' => 'super-admin',
        //         'editable' => false
        //     ]);
        // }
        

        // // assign created user to super admin role
        // DB::table('user_role')->insertOrIgnore([
        //     'user_id'=> $super_admin_id,
        //     'role_id'=> $super_admin_role_id
        // ]);

        // $permissions = json_decode(file_get_contents(base_path().'/database/data/permissions.json'),true);

        // // seed super admin permissions that means all permissions
        // DB::table('permissions')->insertOrIgnore($permissions);


        // // assign all permissions to super-admin role
        // $all_permissions = DB::table('permissions')->pluck('id');

        // foreach($all_permissions as $permission)
        // {
        //     DB::table('role_permission')->insertOrIgnore([
                
        //             'role_id' => $super_admin_role_id,
        //             'permission_id' => $permission 
                
        //     ]);
        // }
        
    }
}


// php artisan db:seed --class=SuperAdminSeeder