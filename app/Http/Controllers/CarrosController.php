<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class CarrosController extends Controller
{
    public function getCarroBYcode($codigo) {
        $codigo = substr($codigo, -1);
        $data = Veiculo::find($codigo);
        if($data) {
            $data->reserva = Reserva::where('veiculo_id', $data->id)->where('data_hora_checkout', null)->first();
        }
        return response()->json($data);
    }
}
