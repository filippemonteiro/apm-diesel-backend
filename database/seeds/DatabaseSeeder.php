<?php

use App\Models\Cargos;
use App\Models\ModalidadesModel;
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
            'name' => 'Admin',
            'email' => 'admin@admin.com.br',
            'password' => Hash::make('123456'),
            'role' => '1',
        ]);
    }
}
