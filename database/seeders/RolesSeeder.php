<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'code' => 'super_admin',
                'name' => 'Super Admin',
                'description' => 'Acceso total y gestiÃ³n de usuarios',
                'is_system' => true,
            ],
            [
                'code' => 'admin',
                'name' => 'Administrador',
                'description' => 'Acceso completo al sistema',
                'is_system' => true,
            ],
            [
                'code' => 'vendedor',
                'name' => 'Vendedor',
                'description' => 'Gestión de ventas y clientes',
                'is_system' => true,
            ],
            [
                'code' => 'almacenero',
                'name' => 'Almacenero',
                'description' => 'Gestión de inventario y recepciones',
                'is_system' => true,
            ],
            [
                'code' => 'customer',
                'name' => 'Cliente',
                'description' => 'Cliente de la tienda online',
                'is_system' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['code' => $role['code']],
                $role
            );
        }
    }
}
