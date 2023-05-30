<?php

namespace Database\Seeders;

use App\Models\User;
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

        // create a user 
        $created_user_id = DB::table('users')->insertGetId([
            'name' => 'superadmin',
            'email' => 'superadmin@ninenews.com',
            'password' => Hash::make('superadmin'),
        ]);

        // get the user by id
        $created_user = User::find($created_user_id);

        // assign super-admin role to created user
        $created_user->assignRole('super-admin');
        
    }
}


// php artisan db:seed --class=SuperAdminSeeder