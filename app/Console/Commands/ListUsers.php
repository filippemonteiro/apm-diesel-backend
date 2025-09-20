<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lista todos os usuários do sistema';

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
        $users = User::all();
        
        $this->info('=== USUÁRIOS NO SISTEMA ===');
        $this->info('Total de usuários: ' . $users->count());
        $this->info('');
        
        if ($users->count() == 0) {
            $this->warn('Nenhum usuário encontrado no banco de dados!');
            $this->info('Execute: php artisan user:create-test para criar um usuário de teste');
            return 0;
        }
        
        foreach ($users as $user) {
            $this->info('ID: ' . $user->id);
            $this->info('Nome: ' . $user->name);
            $this->info('Email: ' . $user->email);
            $this->info('Role: ' . $user->role);
            $this->info('Ativo: ' . ($user->ativo ? 'Sim' : 'Não'));
            $this->info('Criado em: ' . $user->created_at);
            $this->info('---');
        }
        
        return 0;
    }
}