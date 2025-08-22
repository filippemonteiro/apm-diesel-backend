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

            // totalVehicles: dashboardData.total_carros || 0,
            // availableVehicles: dashboardData.carros_disponiveis || 0,
            // inUseVehicles: dashboardData.carros_em_uso || 0,
            // maintenanceVehicles: dashboardData.carros_manutencao || 0,
            // totalUsers: dashboardData.total_usuarios || 0,
            // pendingRequests: dashboardData.chamados_pendentes || 0,

            return response()->json([
                'data' => [
                    'total_carros' => Veiculo::get()->count(),
                    'carros_disponiveis' => Veiculo::get()->count(),
                    'carros_em_uso' => Reserva::whereNull('data_hora_checkout')->get()->count(),
                    'carros_manutencao' => Reserva::whereNull('data_hora_checkout')->get()->count(),
                    'total_usuarios' => User::get()->count(),
                    'chamados_pendentes' => Reserva::get()->count(),
                ]
            ]);
            
           
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);

        }
    }
}