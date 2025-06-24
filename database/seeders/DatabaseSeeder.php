<?php

use App\Cidades;
use App\Estados;
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

        $estado = Estados::create([
            'nome' => 'Ceará',
        ]);
        
        $cidade = Cidades::create([
            'nome' => 'Fortaleza',
            'estado_id' => $estado->id
        ]);

        User::create([
            'name' => 'Ramon',
            'email' => 'ramon.ecotrackapp@gmail.com',
            'password' => Hash::make('Senh@123'),
            'role' => User::SUPERADMIN,
        ]);

        User::create([
            'name' => 'Suporte Admin',
            'email' => 'admin@admin.com.br',
            'password' => Hash::make('Senh@123'),
            'role' => User::SUPERADMIN,
        ]);

        // User::create([
        //     'name' => 'Administrador',
        //     'email' => 'administrador@administrador.com.br',
        //     'password' => Hash::make('Senh@123'),
        //     'role' => User::ADMINISTRADOR,
        //     'cidade_id' => $cidade->id
        // ]);

        // User::create([
        //     'name' => 'Operador',
        //     'email' => 'operador@operador.com.br',
        //     'password' => Hash::make('Senh@123'),
        //     'role' => User::OPERADOR,
        //     'cidade_id' => $cidade->id
        // ]);

        // User::create([
        //     'name' => 'Motorista',
        //     'email' => 'motorista@motorista.com.br',
        //     'password' => Hash::make('Senh@123'),
        //     'role' => User::MOTORISTA,
        //     'cidade_id' => $cidade->id
        // ]);

        // User::create([
        //     'name' => 'Publico',
        //     'email' => 'publico@publico.com.br',
        //     'password' => Hash::make('Senh@123'),
        //     'role' => User::PUBLICO,
        //     'cidade_id' => $cidade->id
        // ]);

        
    }
}
