<?php
namespace App\Services\Relatorios;

use App\Models\Produto as Model;

class ProdutosRelatorios extends RelatoriosServices {
    
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function config($request) {
        $all = $this->model->orderBy('titulo', 'asc')->get();
        
        $this->name = 'produtos';
        $this->view = 'relatorios.produtos';
        $this->data = $all;
    }

}