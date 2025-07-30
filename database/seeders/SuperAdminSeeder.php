<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Muhannad.H ',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'email' => 'muhannad@gmail.com',
            'password' => Hash::make('123123123')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Syed Ahsan Kamal',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
            'email' => 'muhannad1@gmail.com',
            'password' => Hash::make('123123123')
        ]);
        $admin->assignRole('Admin');
    }
}
