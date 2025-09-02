<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um usuário de teste para login';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Verifica se já existe um usuário de teste
        $existingUser = User::where('email', 'teste@teste.com')->first();
        
        if ($existingUser) {
            $this->info('Usuário de teste já existe!');
            $this->info('Email: teste@teste.com');
            $this->info('Senha: 123456');
            return 0;
        }

        // Cria o usuário de teste
        $user = User::create([
            'name' => 'Usuário Teste',
            'email' => 'teste@teste.com',
            'password' => Hash::make('123456'),
            'role' => '1', // Admin
            'ativo' => 1
        ]);

        $this->info('Usuário de teste criado com sucesso!');
        $this->info('Email: teste@teste.com');
        $this->info('Senha: 123456');
        $this->info('Role: 1 (Admin)');
        
        return 0;
    }
}
