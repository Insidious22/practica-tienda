<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Admin tiene todos los permisos
        $admin = Role::where('code', 'admin')->first();
        if ($admin) {
            $admin->permissions()->sync(Permission::pluck('id'));
        }

        // Vendedor
        $vendedor = Role::where('code', 'vendedor')->first();
        if ($vendedor) {
            $vendedorPermissions = Permission::whereIn('code', [
                'products.view',
                'categories.view',
                'zones.view',
                'sales.view',
                'sales.create',
                'customers.view',
                'customers.create',
                'customers.edit',
                'inventory.view',
                'reports.sales',
            ])->pluck('id');
            $vendedor->permissions()->sync($vendedorPermissions);
        }

        // Almacenero
        $almacenero = Role::where('code', 'almacenero')->first();
        if ($almacenero) {
            $almaceneroPermissions = Permission::whereIn('code', [
                'products.view',
                'products.edit',
                'categories.view',
                'zones.view',
                'suppliers.view',
                'purchases.view',
                'purchases.receive',
                'inventory.view',
                'inventory.adjust',
                'inventory.transfer',
                'inventory.receive_transfer',
                'reports.inventory',
            ])->pluck('id');
            $almacenero->permissions()->sync($almaceneroPermissions);
        }
    }
}
