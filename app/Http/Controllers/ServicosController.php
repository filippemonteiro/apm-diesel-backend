<?php

namespace App\Http\Controllers;

use App\Services\ServicosServices as Services;
use Illuminate\Http\Request;

class ServicosController extends ApiController 
{
    protected $services = null;

    public function __construct(Services $services) 
    {
        $this->services = $services;
    }

    /**
     * Listar serviços por tipo
     */
    public function porTipo($tipo, Request $request)
    {
        $request->merge(['tipo' => $tipo]);
        return $this->services->index($request);
    }

    /**
     * Listar serviços por motorista
     */
    public function porMotorista($motoristaId, Request $request)
    {
        $request->merge(['motorista_id' => $motoristaId]);
        return $this->services->index($request);
    }

    /**
     * Listar serviços por veículo
     */
    public function porVeiculo($veiculoId, Request $request)
    {
        $request->merge(['veiculo_id' => $veiculoId]);
        return $this->services->index($request);
    }
}