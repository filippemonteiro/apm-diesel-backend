<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Veiculo;
use App\Models\ServiceRequest;
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

            // Contar veículos por status
            $totalCarros = Veiculo::count();
            $carrosDisponiveis = Veiculo::where('status', 'disponivel')->count();
            $carrosEmUso = Veiculo::where('status', 'em_uso')->count();
            $carrosManutencao = Veiculo::where('status', 'manutencao')->count();
            
            // Contar usuários
            $totalUsuarios = User::count();
            
            // Contar chamados pendentes (serviços agendados)
            $chamadosPendentes = ServiceRequest::where('status', 'AGENDADO')->count();

            return response()->json([
                'data' => [
                    'total_carros' => $totalCarros,
                    'carros_disponiveis' => $carrosDisponiveis,
                    'carros_em_uso' => $carrosEmUso,
                    'carros_manutencao' => $carrosManutencao,
                    'total_usuarios' => $totalUsuarios,
                    'chamados_pendentes' => $chamadosPendentes,
                ]
            ]);
            
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}