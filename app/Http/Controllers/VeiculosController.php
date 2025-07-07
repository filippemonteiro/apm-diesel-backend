<?php

namespace App\Http\Controllers;

use App\Services\VeiculosServices as Services;

class VeiculosController extends ApiController 
{
    protected $services = null;

    public function __construct(Services $services) 
    {
        $this->services = $services;
    }
}