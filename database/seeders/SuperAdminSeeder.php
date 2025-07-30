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
<<<<<<< HEAD
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin')
=======
            'email' => 'muhannad@gmail.com',
            'password' => Hash::make('123123123')
>>>>>>> ef2e2fc6e3d7832749c2ad237500afd81227b710
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Syed Ahsan Kamal',
<<<<<<< HEAD
            'email' => 'user@gmail.com',
            'password' => Hash::make('user')
=======
            'email' => 'muhannad1@gmail.com',
            'password' => Hash::make('123123123')
>>>>>>> ef2e2fc6e3d7832749c2ad237500afd81227b710
        ]);
        $admin->assignRole('Admin');


    }
}
