<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class UsersTableSeeder extends Seeder
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

        $superAdminRole = Role::where('name', '=', 'SuperAdmin')->first();
        $adminRole = Role::where('name', '=', 'Admin')->first();
        $employerRole = Role::where('name', '=', 'Employer')->first();
        $hodRole = Role::where('name', '=', 'HOD')->first();
        $clientRole = Role::where('name', '=', 'Client')->first();
        $contactRole = Role::where('name', '=', 'Contact')->first();
        $supplierRole = Role::where('name', '=', 'Supplier')->first();
        $shipperRole = Role::where('name', '=', 'Shipper')->first();
        $userRole = Role::where('name', '=', 'User')->first();

        $permissions = Permission::all();
        // $hodPerms = Permission::whereIn('name',['manage shipper quotes', 'manage supplier quotes', 'manage shipper ratings', 'manage shippers', 'manage suppliers', 'manage clients', 'manage articles', 'manage client contacts', 'manage users'])->get();
        // $clientPerms = Permission::whereIn('name',['manage client contacts', 'manage users'])->get();
        // $employerPerms = Permission::whereIn('name',['manage shipper quotes', 'manage supplier quotes', 'manage shipper ratings', 'manage shippers', 'manage suppliers', 'manage clients', 'manage articles', 'manage client contacts', 'manage users'])->get();
        // $shipperPerms = Permission::where('name', '=', 'manage shipper quotes')->first();
        // $supplierPerms = Permission::where('name', '=', 'manage supplier quotes')->first();

        /*
         * Add Users
         *
         */
        if (User::where('email', '=', 'yg@enabledsolutions.net')->first() === null) {
            $newUser = User::create([
                'first_name'     => 'Yemi',
                'last_name'     => 'Gbadamosi',
                'email'    => 'yg@enabledsolutions.net',
                'password' => bcrypt('password'),
                'phone_number' => '07038797386',
                'role' => 'SuperAdmin',
                'user_activation_code' => md5(rand(8,15)),
                'email_verified_at' => date('Y-m-d h:i:s')
            ]);

            $newUser->assignRole($superAdminRole);
            foreach ($permissions as $permission) {
                $newUser->givePermissionTo($permission);
            }
        }

        if (User::where('email', '=', 'ag@enabledgroup.net')->first() === null) {
            $newUser = User::create([
                'first_name'     => 'Anne',
                'last_name'     => 'Gbadamosi',
                'email'    => 'ag@enabledgroup.net',
                'password' => bcrypt('password'),
                'phone_number' => '07038797386',
                'role' => 'SuperAdmin',
                'user_activation_code' => md5(rand(8,15)),
                'email_verified_at' => date('Y-m-d h:i:s')
            ]);

            $newUser->assignRole($superAdminRole);
            foreach ($permissions as $permission) {
                $newUser->givePermissionTo($permission);
            }
        }

        if (User::where('email', '=', 'azeez@enabledgroup.net')->first() === null) {
            $newUser = User::create([
                'first_name'     => 'Azeez',
                'last_name'     => 'Adigun',
                'email'    => 'azeez@enabledgroup.net',
                'password' => bcrypt('password'),
                'phone_number' => '07038797386',
                'role' => 'SuperAdmin',
                'user_activation_code' => md5(rand(8,15)),
                'email_verified_at' => date('Y-m-d h:i:s')
            ]);

            $newUser->assignRole($superAdminRole);
            foreach ($permissions as $permission) {
                $newUser->givePermissionTo($permission);
            }
        }

        if (User::where('email', '=', 'taiwo@enabledgroup.net')->first() === null) {
            $newUser = User::create([
                'first_name'     => 'Taiwo',
                'last_name'     => 'Adesina',
                'email'    => 'taiwo@enabledgroup.net',
                'password' => bcrypt('password'),
                'phone_number' => '07038797386',
                'role' => 'SuperAdmin',
                'user_activation_code' => md5(rand(8,15)),
                'email_verified_at' => date('Y-m-d h:i:s')
            ]);

            $newUser->assignRole($superAdminRole);
            foreach ($permissions as $permission) {
                $newUser->givePermissionTo($permission);
            }
        }

        if (User::where('email', '=', 'admin@enabledgroup.net')->first() === null) {
            $newUser = User::create([
                'first_name'     => 'Admin',
                'last_name'     => 'User',
                'email'    => 'admin@enabledgroup.net',
                'password' => bcrypt('password'),
                'phone_number' => '07038797386',
                'role' => 'Admin',
                'user_activation_code' => md5(rand(8,15)),
                'email_verified_at' => date('Y-m-d h:i:s')
            ]);

            $newUser->assignRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->givePermissionTo($permission);
            }
        }

        // if (User::where('email', '=', 'employer@enabledgroup.net')->first() === null) {
        //     $newUser = User::create([
        //         'first_name'     => 'Employer',
        //         'last_name'     => 'Account',
        //         'email'    => 'employer@enabledgroup.net',
        //         'password' => bcrypt('password'),
        //         'phone_number' => '07038797386',
        //         'role' => 'Employer',
        //         'user_activation_code' => md5(rand(8,15)),
        //         'email_verified_at' => date('Y-m-d h:i:s')
        //     ]);

        //     $newUser->assignRole($employerRole);
        //     foreach ($employerPerms as $permission) {
        //         $newUser->givePermissionTo($permission);
        //     }
        // }

        // if (User::where('email', '=', 'hod@enabledgroup.net')->first() === null) {
        //     $newUser = User::create([
        //         'first_name'     => 'Hod',
        //         'last_name'     => 'Account',
        //         'email'    => 'hod@enabledgroup.net',
        //         'password' => bcrypt('password'),
        //         'phone_number' => '07038797386',
        //         'role' => 'HOD',
        //         'user_activation_code' => md5(rand(8,15)),
        //         'email_verified_at' => date('Y-m-d h:i:s')
        //     ]);

        //     $newUser->assignRole($hodRole);
        //     foreach ($hodPerms as $permission) {
        //         $newUser->givePermissionTo($permission);
        //     }
        // }

        // if (User::where('email', '=', 'client@enabledgroup.net')->first() === null) {
        //     $newUser = User::create([
        //         'first_name'     => 'Client',
        //         'last_name'     => 'Account',
        //         'email'    => 'client@enabledgroup.net',
        //         'password' => bcrypt('password'),
        //         'phone_number' => '07038797386',
        //         'role' => 'Client',
        //         'user_activation_code' => md5(rand(8,15)),
        //         'email_verified_at' => date('Y-m-d h:i:s')
        //     ]);

        //     $newUser->assignRole($clientRole);
        //     foreach ($clientPerms as $permission) {
        //         $newUser->givePermissionTo($permission);
        //     }
        // }

        // if (User::where('email', '=', 'supplier@enabledgroup.net')->first() === null) {
        //     $newUser = User::create([
        //         'first_name'     => 'Supplier',
        //         'last_name'     => 'Account',
        //         'email'    => 'supplier@enabledgroup.net',
        //         'password' => bcrypt('password'),
        //         'phone_number' => '07038797386',
        //         'role' => 'Supplier',
        //         'user_activation_code' => md5(rand(8,15)),
        //         'email_verified_at' => date('Y-m-d h:i:s')
        //     ]);

        //     $newUser->assignRole($supplierRole);
        //     $newUser->givePermissionTo($supplierPerms);
        // }

        // if (User::where('email', '=', 'shipper@enabledgroup.net')->first() === null) {
        //     $newUser = User::create([
        //         'first_name'     => 'Shipper',
        //         'last_name'     => 'Account',
        //         'email'    => 'shipper@enabledgroup.net',
        //         'password' => bcrypt('password'),
        //         'phone_number' => '07038797386',
        //         'role' => 'Shipper',
        //         'user_activation_code' => md5(rand(8,15)),
        //         'email_verified_at' => date('Y-m-d h:i:s')
        //     ]);

        //     $newUser->assignRole($shipperRole);
        //     $newUser->givePermissionTo($shipperPerms);
        // }

        // if (User::where('email', '=', 'contact@enabledgroup.net')->first() === null) {
        //     $newUser = User::create([
        //         'first_name'     => 'Contact',
        //         'last_name'     => 'Account',
        //         'email'    => 'contact@enabledgroup.net',
        //         'password' => bcrypt('password'),
        //         'phone_number' => '07038797386',
        //         'role' => 'Contact',
        //         'user_activation_code' => md5(rand(8,15)),
        //         'email_verified_at' => date('Y-m-d h:i:s')
        //     ]);

        //     $newUser->assignRole($contactRole);
        // }

        if (User::where('email', '=', 'user@enabledgroup.net')->first() === null) {
            $newUser = User::create([
                'first_name'     => 'User',
                'last_name'     => 'Account',
                'email'    => 'user@enabledgroup.net',
                'password' => bcrypt('password'),
                'phone_number' => '07038797386',
                'role' => 'User',
                'user_activation_code' => md5(rand(8,15)),
                'email_verified_at' => date('Y-m-d h:i:s')
            ]);

            $newUser->assignRole($userRole);
        }

    }
}
