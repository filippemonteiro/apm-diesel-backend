<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;

class CarrosController extends Controller
{
    public function getCarroBYcode($codigo) {
        $codigo = substr($codigo, -1);
        $data = Veiculo::find($codigo);
        return response()->json($data);
    }
}
