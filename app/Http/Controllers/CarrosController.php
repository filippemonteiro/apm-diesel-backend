<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;

class CarrosController extends Controller
{
    public function getCarroBYcode($codigo) {
        $data = Veiculo::where('qrCode', $codigo)->first();
        return response()->json($data);
    }
}
