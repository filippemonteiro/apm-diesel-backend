<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Veiculo;
use App\User;
use Exception;
use Illuminate\Http\Request;
class DashboardController extends Controller {

    public function __construct() {
    }

    /**
    * @Route("/dashboard/totais")
    */
    public function totais(Request $request) {
        try {

            $user = $request->user();

            return response()->json([
                'data' => [
                    'total_veiculos' => Veiculo::get()->count(),
                    'total_veiculos_disponiveis' => Veiculo::get()->count(),
                    'total_veiculos_uso' => Reserva::whereNull('data_hora_checkout')->get()->count(),
                    'total_veiculos_manutencao' => Reserva::whereIsNull('data_hora_checkout')->get()->count(),
                    'total_usuarios' => User::get()->count(),
                    'total_chamados' => Reserva::get()->count(),
                ]
            ]);
            
           
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);

        }
    }
}