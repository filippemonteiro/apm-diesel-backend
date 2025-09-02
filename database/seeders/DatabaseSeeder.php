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
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'role' => User::SUPERADMIN,
        ]);

        // Criar alguns veículos de teste
        \App\Models\Veiculo::create([
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'placa' => 'ABC1234',
            'ano' => 2020,
            'cor' => 'Branco',
            'km' => 50000,
            'combustivel' => 'Flex',
            'status' => 'disponivel'
        ]);

        \App\Models\Veiculo::create([
            'marca' => 'Honda',
            'modelo' => 'Civic',
            'placa' => 'DEF5678',
            'ano' => 2021,
            'cor' => 'Preto',
            'km' => 30000,
            'combustivel' => 'Flex',
            'status' => 'disponivel'
        ]);
        
    }
}
