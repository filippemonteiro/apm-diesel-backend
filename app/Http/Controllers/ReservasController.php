<?php

namespace App\Http\Controllers;

use App\Services\ReservasServices as Services;
use Illuminate\Http\Request;

class ReservasController extends ApiController 
{
    protected $services = null;

    public function __construct(Services $services) 
    {
        $this->services = $services;
    }

    /**
     * Listar reservas por motorista
     */
    public function porMotorista($motoristaId, Request $request)
    {
        $request->merge(['motorista_id' => $motoristaId]);
        return $this->services->index($request);
    }

    /**
     * Listar reservas por veículo
     */
    public function porVeiculo($veiculoId, Request $request)
    {
        $request->merge(['veiculo_id' => $veiculoId]);
        return $this->services->index($request);
    }
}