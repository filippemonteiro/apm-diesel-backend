<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatoriosController extends Controller {

    protected $services = null;

    public function index(Request $request) {

        ini_set('max_execution_time', '600'); //300 seconds = 5 minutes

        $params = $request->all();
        $service = ucfirst($params['tipo']);
        $class = "App\Services\Relatorios\\" . $service . "Relatorios";
        $relatorio = new $class();
        return $relatorio->make($params);
    }   

}
