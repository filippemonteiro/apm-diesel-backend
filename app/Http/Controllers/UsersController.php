<?php
namespace App\Http\Controllers;

use App\Services\UsersServices as Services;
use App\User;

class UsersController extends ApiController {

    public function __construct(Services $services) {
        $this->services = $services;
    }

    public function autorizacoes() {
        $data =  User::getTypes();
        return response()->json($data);
    }
}