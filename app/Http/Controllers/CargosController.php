<?php

namespace App\Http\Controllers;

use App\Services\CargosServices as Services;

class CargosController extends ApiController {

    protected $services = null;

    public function __construct(Services $services) {
        $this->services = $services;
    }
}