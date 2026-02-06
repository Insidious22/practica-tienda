<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@tienda.local'],
            [
                'name' => 'Super Admin',
                'password' => 'password',
                'phone' => '09999999999',
            ]
        );

        // Asignar rol super_admin
        $superAdminRole = Role::where('code', 'super_admin')->first();
        if ($superAdminRole && !$superAdmin->roles->contains($superAdminRole)) {
            $superAdmin->roles()->attach($superAdminRole, [
                'assigned_by' => $superAdmin->id,
                'assigned_at' => now(),
            ]);
        }

        // Crear Admin regular
        $admin = User::firstOrCreate(
            ['email' => 'admin@tienda.local'],
            [
                'name' => 'Administrador',
                'password' => 'password',
                'phone' => '09988888888',
            ]
        );

        // Asignar rol admin
        $adminRole = Role::where('code', 'admin')->first();
        if ($adminRole && !$admin->roles->contains($adminRole)) {
            $admin->roles()->attach($adminRole, [
                'assigned_by' => $superAdmin->id,
                'assigned_at' => now(),
            ]);
        }

        echo "✓ Super Admin creado: superadmin@tienda.local / password\n";
        echo "✓ Admin creado: admin@tienda.local / password\n";
    }
}
