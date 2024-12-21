<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $adminUser = User::firstOrCreate([
            'email' => 'suhelkhan6040@gmail.com'
        ], [
            'name' => 'Admin',
            'email' => 'suhelkhan6040@gmail.com',
            'gender' => 'male',
            'phone' => '1234567890',
            'city'=>'Indore',
            'address'=>'Indore',
            'password' => Hash::make('838485'),
        ]);

        $superAdminUser = User::firstOrCreate([
            'email' => 'suhel@velsof.com',
        ], [
            'name' => 'Suhel Khan',
            'email' => 'suhel@velsof.com',
            'gender' => 'male',
            'phone' => '1234567890',
            'city'=>'Indore',
            'address'=>'Indore',
            'password' => Hash::make('838485'),
        ]);

        $staffUser = User::firstOrCreate([
            'email' => 'staff@gmail.com',
        ], [
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'gender' => 'male',
            'phone' => '1234567890',
            'city'=>'Indore',
            'address'=>'Indore',
            'password' => Hash::make('12345678'),
        ]);

        // Create Permissions
        Permission::firstOrCreate(['name' => 'view role']);
        Permission::firstOrCreate(['name' => 'create role']);
        Permission::firstOrCreate(['name' => 'update role']);
        Permission::firstOrCreate(['name' => 'delete role']);

        Permission::firstOrCreate(['name' => 'view permission']);
        Permission::firstOrCreate(['name' => 'create permission']);
        Permission::firstOrCreate(['name' => 'update permission']);
        Permission::firstOrCreate(['name' => 'delete permission']);

        Permission::firstOrCreate(['name' => 'view user']);
        Permission::firstOrCreate(['name' => 'create user']);
        Permission::firstOrCreate(['name' => 'update user']);
        Permission::firstOrCreate(['name' => 'delete user']);

        Permission::firstOrCreate(['name' => 'view product']);
        Permission::firstOrCreate(['name' => 'create product']);
        Permission::firstOrCreate(['name' => 'update product']);
        Permission::firstOrCreate(['name' => 'delete product']);


        // Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']); //as super-admin
        $adminRole = Role::firstOrCreate(['name' => 'Blood Bank User']);
        $staffRole = Role::firstOrCreate(['name' => 'Application User']);

        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();

        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
        $adminRole->givePermissionTo(['create role', 'view role', 'update role']);
        $adminRole->givePermissionTo(['create permission', 'view permission']);
        $adminRole->givePermissionTo(['create user', 'view user', 'update user']);
        $adminRole->givePermissionTo(['create product', 'view product', 'update product']);


        // Let's Create User and assign Role to it.

    
        $superAdminUser->assignRole($superAdminRole);

        $adminUser->assignRole($adminRole);

        $staffUser->assignRole($staffRole);
    }
}
