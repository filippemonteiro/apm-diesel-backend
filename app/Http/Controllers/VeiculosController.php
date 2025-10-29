<?php

namespace App\Http\Controllers;

use App\Services\VeiculosServices as Services;
use Illuminate\Http\Request;

class VeiculosController extends ApiController 
{
    protected $services = null;

    public function __construct(Services $services) 
    {
        $this->services = $services;
    }

    public function listaDisponiveis(Request $request) {
        return $this->services->listarDisponiveis($request);
    }

    public function listaNaoDisponiveis(Request $request) {
        return $this->services->listarNaoDisponiveis($request);
    }
}