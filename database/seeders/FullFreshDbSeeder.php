<?php

namespace Database\Seeders;

use App\Models\Setting\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FullFreshDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Cache::flush();
        Schema::disableForeignKeyConstraints();
        
        $this->call(PermissionSeeder::class);
        $this->call(SuperAdminSeeder::class);

        $this->call(TagSeeder::class);

        
        Schema::enableForeignKeyConstraints();
    
    }
}


//php artisan db:seed --class=FullFreshDbSeeder