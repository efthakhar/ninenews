<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    private $permissions = [
       'create-tags', 'view-tags', 'update-tags', 'delete-tags',
       'create-categories', 'view-categories', 'update-categories', 'delete-categories',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::truncate();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission ]);
        }
    }
}
