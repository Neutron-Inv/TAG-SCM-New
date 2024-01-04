<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manage articles']);
        Permission::create(['name' => 'manage all users']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage clients']);
        Permission::create(['name' => 'manage client contacts']);
        Permission::create(['name' => 'manage suppliers']);
        Permission::create(['name' => 'manage shippers']);
        Permission::create(['name' => 'manage shipper quotes']);
        Permission::create(['name' => 'manage supplier quotes']);
        Permission::create(['name' => 'manage shipper ratings']);
        Permission::create(['name' => 'manage audit trail']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'SuperAdmin']);
        $role->givePermissionTo(Permission::all());

        // chain permission(s) to respective role
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Employer'])
            ->givePermissionTo(['manage shipper quotes', 'manage supplier quotes', 'manage shipper ratings', 'manage client contacts', 'manage articles', 'manage shippers', 'manage suppliers', 'manage clients', 'manage users']);

        $role = Role::create(['name' => 'HOD'])
            ->givePermissionTo(['manage shipper quotes', 'manage supplier quotes', 'manage shipper ratings', 'manage client contacts', 'manage articles', 'manage shippers', 'manage suppliers', 'manage clients', 'manage users']);

        $role = Role::create(['name' => 'Client'])
            ->givePermissionTo(['manage client contacts', 'manage users']);

        $role = Role::create(['name' => 'Supplier'])
            ->givePermissionTo(['manage shipper quotes']);
        
        $role = Role::create(['name' => 'Shipper'])
            ->givePermissionTo(['manage shipper quotes']);

        $role = Role::create(['name' => 'Contact']);

        $role = Role::create(['name' => 'User']);
        
    }
}
