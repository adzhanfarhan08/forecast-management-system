<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);

        // Dummy Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Dummy',
                'password' => Hash::make('123'),
            ]
        );
        $admin->assignRole($adminRole);

        // Dummy Owner
        $owner = User::firstOrCreate(
            ['email' => 'owner@example.com'],
            [
                'name' => 'Owner Dummy',
                'password' => Hash::make('123'),
                'password' => Hash::make('123'),
            ]
        );
        $owner->assignRole($ownerRole);

        // Dummy Employee
        $employee = User::firstOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name' => 'Employee Dummy',
                'password' => Hash::make('123'),
            ]
        );
        $employee->assignRole($employeeRole);
    }
}
