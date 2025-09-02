<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Veiculo;
use App\Models\VehicleCheckin;
use App\Models\VehicleCheckout;
use App\User;
use Illuminate\Http\Request;
use Exception;

class RelatoriosController extends Controller
{
    /**
     * Buscar relatórios
     * GET /relatorios
     */
    public function index(Request $request)
    {
        try {
            ini_set('max_execution_time', '600'); // 10 minutos

            // Relatório básico com dados gerais
            $data = [
                'resumo_geral' => [
                    'total_veiculos' => Veiculo::count(),
                    'veiculos_disponiveis' => Veiculo::where('status', 'available')->count(),
                    'veiculos_em_uso' => Veiculo::where('status', 'in_use')->count(),
                    'veiculos_manutencao' => Veiculo::where('status', 'maintenance')->count(),
                    'total_usuarios' => User::count(),
                    'servicos_agendados' => ServiceRequest::where('status', 'AGENDADO')->count(),
                    'servicos_concluidos' => ServiceRequest::where('status', 'CONCLUIDO')->count(),
                ],
                'servicos_por_tipo' => [
                    'combustivel' => ServiceRequest::where('tipo', 'combustivel')->count(),
                    'manutencao' => ServiceRequest::where('tipo', 'manutencao')->count(),
                ],
                'ultimos_servicos' => ServiceRequest::with(['veiculo', 'motorista'])
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get()
                    ->map(function ($servico) {
                        return [
                            'id' => $servico->id,
                            'tipo' => $servico->tipo,
                            'data' => $servico->data->format('Y-m-d'),
                            'status' => $servico->status,
                            'veiculo' => $servico->veiculo->marca . ' ' . $servico->veiculo->modelo,
                            'motorista' => $servico->motorista->name,
                        ];
                    }),
                'veiculos_mais_utilizados' => Veiculo::withCount('checkins')
                    ->orderBy('checkins_count', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($veiculo) {
                        return [
                            'id' => $veiculo->id,
                            'veiculo' => $veiculo->marca . ' ' . $veiculo->modelo . ' - ' . $veiculo->placa,
                            'total_checkins' => $veiculo->checkins_count ?? 0,
                        ];
                    }),
            ];

            return response()->json([
                'data' => $data
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
