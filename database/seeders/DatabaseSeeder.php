<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Crea el rol de admin si no existe
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crea el usuario administrador y asigna el rol de admin
        $adminUser = User::factory(1)->create([
            'name' => "Base admin",
            'email' => "email@mailinator.com",
        ])->first();

        $adminUser->assignRole($adminRole);
    }
}
