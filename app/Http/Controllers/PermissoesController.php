<?php

namespace App\Http\Controllers;

use App\Services\PermissoesServices as Services;

class PermissoesController extends ApiController {

    protected $services = null;

    public function __construct(Services $services) {
        $this->services = $services;
    }
}