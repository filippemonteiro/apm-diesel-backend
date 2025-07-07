<?php

namespace App\Http\Controllers;

use App\Services\TiposServicosServices as Services;

class TiposServicosController extends ApiController 
{
    protected $services = null;

    public function __construct(Services $services) 
    {
        $this->services = $services;
    }
}