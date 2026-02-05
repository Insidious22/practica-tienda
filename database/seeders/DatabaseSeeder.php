<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders base del sistema
        $this->call([
            RolesSeeder::class,
            PermissionsSeeder::class,
            RolePermissionSeeder::class,
            PaymentMethodsSeeder::class,
            InventoryMovementTypesSeeder::class,
            InventorySeeder::class,
            AdminUserSeeder::class,  // Usuarios admin
            DemoDataSeeder::class,  // Datos de demostración para el frontend
        ]);

        // Usuario de prueba (cliente)
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        $customerRole = \App\Models\Role::where('code', 'customer')->first();
        if ($customerRole && !$user->roles()->where('code', 'customer')->exists()) {
            $user->roles()->attach($customerRole->id);
        }
    }
}
