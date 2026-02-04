<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Productos
            ['code' => 'products.view', 'name' => 'Ver productos', 'module' => 'products'],
            ['code' => 'products.create', 'name' => 'Crear productos', 'module' => 'products'],
            ['code' => 'products.edit', 'name' => 'Editar productos', 'module' => 'products'],
            ['code' => 'products.delete', 'name' => 'Eliminar productos', 'module' => 'products'],

            // Categorías
            ['code' => 'categories.view', 'name' => 'Ver categorías', 'module' => 'categories'],
            ['code' => 'categories.create', 'name' => 'Crear categorías', 'module' => 'categories'],
            ['code' => 'categories.edit', 'name' => 'Editar categorías', 'module' => 'categories'],
            ['code' => 'categories.delete', 'name' => 'Eliminar categorías', 'module' => 'categories'],

            // Zonas
            ['code' => 'zones.view', 'name' => 'Ver zonas', 'module' => 'zones'],
            ['code' => 'zones.create', 'name' => 'Crear zonas', 'module' => 'zones'],
            ['code' => 'zones.edit', 'name' => 'Editar zonas', 'module' => 'zones'],
            ['code' => 'zones.delete', 'name' => 'Eliminar zonas', 'module' => 'zones'],

            // Ventas
            ['code' => 'sales.view', 'name' => 'Ver ventas', 'module' => 'sales'],
            ['code' => 'sales.create', 'name' => 'Crear ventas', 'module' => 'sales'],
            ['code' => 'sales.cancel', 'name' => 'Cancelar ventas', 'module' => 'sales'],
            ['code' => 'sales.refund', 'name' => 'Reembolsar ventas', 'module' => 'sales'],

            // Clientes
            ['code' => 'customers.view', 'name' => 'Ver clientes', 'module' => 'customers'],
            ['code' => 'customers.create', 'name' => 'Crear clientes', 'module' => 'customers'],
            ['code' => 'customers.edit', 'name' => 'Editar clientes', 'module' => 'customers'],
            ['code' => 'customers.delete', 'name' => 'Eliminar clientes', 'module' => 'customers'],

            // Proveedores
            ['code' => 'suppliers.view', 'name' => 'Ver proveedores', 'module' => 'suppliers'],
            ['code' => 'suppliers.create', 'name' => 'Crear proveedores', 'module' => 'suppliers'],
            ['code' => 'suppliers.edit', 'name' => 'Editar proveedores', 'module' => 'suppliers'],
            ['code' => 'suppliers.delete', 'name' => 'Eliminar proveedores', 'module' => 'suppliers'],

            // Compras
            ['code' => 'purchases.view', 'name' => 'Ver órdenes de compra', 'module' => 'purchases'],
            ['code' => 'purchases.create', 'name' => 'Crear órdenes de compra', 'module' => 'purchases'],
            ['code' => 'purchases.approve', 'name' => 'Aprobar órdenes de compra', 'module' => 'purchases'],
            ['code' => 'purchases.receive', 'name' => 'Recibir mercancía', 'module' => 'purchases'],
            ['code' => 'purchases.cancel', 'name' => 'Cancelar órdenes de compra', 'module' => 'purchases'],

            // Inventario
            ['code' => 'inventory.view', 'name' => 'Ver movimientos de inventario', 'module' => 'inventory'],
            ['code' => 'inventory.adjust', 'name' => 'Realizar ajustes de inventario', 'module' => 'inventory'],
            ['code' => 'inventory.approve_adjustment', 'name' => 'Aprobar ajustes de inventario', 'module' => 'inventory'],
            ['code' => 'inventory.transfer', 'name' => 'Crear transferencias', 'module' => 'inventory'],
            ['code' => 'inventory.receive_transfer', 'name' => 'Recibir transferencias', 'module' => 'inventory'],

            // Usuarios y Roles
            ['code' => 'users.view', 'name' => 'Ver usuarios', 'module' => 'users'],
            ['code' => 'users.create', 'name' => 'Crear usuarios', 'module' => 'users'],
            ['code' => 'users.edit', 'name' => 'Editar usuarios', 'module' => 'users'],
            ['code' => 'users.delete', 'name' => 'Eliminar usuarios', 'module' => 'users'],
            ['code' => 'users.assign_roles', 'name' => 'Asignar roles', 'module' => 'users'],

            // Reportes
            ['code' => 'reports.sales', 'name' => 'Ver reportes de ventas', 'module' => 'reports'],
            ['code' => 'reports.purchases', 'name' => 'Ver reportes de compras', 'module' => 'reports'],
            ['code' => 'reports.inventory', 'name' => 'Ver reportes de inventario', 'module' => 'reports'],
            ['code' => 'reports.export', 'name' => 'Exportar reportes', 'module' => 'reports'],

            // Configuración
            ['code' => 'settings.view', 'name' => 'Ver configuración', 'module' => 'settings'],
            ['code' => 'settings.edit', 'name' => 'Editar configuración', 'module' => 'settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['code' => $permission['code']],
                $permission
            );
        }
    }
}
