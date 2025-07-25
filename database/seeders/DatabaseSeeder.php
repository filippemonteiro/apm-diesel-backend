<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Suporte Admin',
            'email' => 'admin@admin.com.br',
            'password' => Hash::make('Senh@123'),
            'role' => User::SUPERADMIN,
        ]);
        
    }
}
