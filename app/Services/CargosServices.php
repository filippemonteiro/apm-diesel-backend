<?php
namespace App\Services;

use App\Cargos as Model;

class CargosServices extends BaseServices {
    
    public function __construct(Model $model)
    {
        $this->indexOptions['label'] = 'nome';
        $this->model = $model;
    }

}