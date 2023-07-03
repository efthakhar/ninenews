<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    private $permissions = [
       'create-tags', 'view-tags', 'update-tags', 'delete-tags',
       'create-categories', 'view-categories', 'update-categories', 'delete-categories',
       'create-posts', 'view-posts', 'update-posts', 'deposte-tags',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::truncate();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::truncate();
        $super_admin_role = Role::create(['name' => 'super-admin']);
        
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission ]);
            $super_admin_role->givePermissionTo( $permission);
        }
    }
}
