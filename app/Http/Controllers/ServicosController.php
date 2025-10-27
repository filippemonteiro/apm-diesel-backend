<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\ServiceRequest;
use App\Models\Veiculo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ServicosController extends Controller
{
    /**
     * Listar solicitações de serviço com filtros
     * GET /servicos
     */
    public function index(Request $request)
    {
        try {
            $reservas = Reserva::when($request, function($query, $request) {
                if ($request->has('motorista_id')) {
                    $query->where('motorista_id', $request->motorista_id);
                }

                if ($request->has('veiculo_id')) {
                    $query->where('veiculo_id', $request->veiculo_id);
                }
                return $query;
            })
            ->orderBy('data_hora_checkin', 'desc')
            ->paginate(10);

          

            return response()->json([
                'data' => $reservas
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Criar solicitação de serviço
     * POST /servicos
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tipo' => 'required|string|in:combustivel,manutencao',
                'data' => 'required|date',
                'hora' => 'required|date_format:H:i',
                'observacao' => 'nullable|string',
                'km' => 'required|string',
                'valor' => 'required|numeric|min:0',
                'veiculo_id' => 'required|exists:veiculos,id',
                'motorista_id' => 'required|exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Dados inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $servico = ServiceRequest::create([
                'tipo' => $request->tipo,
                'data' => $request->data,
                'hora' => $request->hora,
                'observacao' => $request->observacao,
                'km' => $request->km,
                'valor' => $request->valor,
                'status' => 'AGENDADO', // Status padrão
                'veiculo_id' => $request->veiculo_id,
                'motorista_id' => $request->motorista_id
            ]);

            // Carregar relacionamentos
            $servico->load(['veiculo', 'motorista']);

            return response()->json([
                'message' => 'Serviço criado com sucesso',
                'data' => [
                    'id' => $servico->id,
                    'tipo' => $servico->tipo,
                    'data' => $servico->data->format('Y-m-d'),
                    'hora' => $servico->hora,
                    'observacao' => $servico->observacao,
                    'km' => $servico->km,
                    'valor' => $servico->valor,
                    'status' => $servico->status,
                    'veiculo' => [
                        'id' => $servico->veiculo->id,
                        'marca' => $servico->veiculo->marca,
                        'modelo' => $servico->veiculo->modelo,
                        'cor' => $servico->veiculo->cor
                    ],
                    'motorista' => [
                        'id' => $servico->motorista->id,
                        'name' => $servico->motorista->name
                    ]
                ]
            ], 201);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Listar serviços por tipo
     */
    public function porTipo($tipo, Request $request)
    {
        $request->merge(['tipo' => $tipo]);
        return $this->index($request);
    }

    /**
     * Listar serviços por motorista
     */
    public function porMotorista($motoristaId, Request $request)
    {
        $request->merge(['motorista_id' => $motoristaId]);
        return $this->index($request);
    }

    /**
     * Listar serviços por veículo
     */
    public function porVeiculo($veiculoId, Request $request)
    {
        $request->merge(['veiculo_id' => $veiculoId]);
        return $this->index($request);
    }
}