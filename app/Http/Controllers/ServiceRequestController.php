<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\Veiculo;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ServiceRequestController extends Controller
{
    /**
     * Listar todas as solicitações de serviço
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = ServiceRequest::with(['veiculo', 'user']);

            // Filtros opcionais
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('priority')) {
                $query->where('priority', $request->priority);
            }

            if ($request->has('veiculo_id')) {
                $query->where('veiculo_id', $request->veiculo_id);
            }

            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->has('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $serviceRequests = $query->orderBy('created_at', 'desc')
                                   ->paginate($request->get('per_page', 15));

            return response()->json([
                'success' => true,
                'data' => $serviceRequests
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Criar nova solicitação de serviço
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'veiculo_id' => 'required|exists:veiculos,id',
            'motorista_id' => 'required|exists:users,id',
            'tipo' => 'required|string|in:combustivel,manutencao',
            'data' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'observacao' => 'nullable|string',
            'km' => 'required|string',
            'valor' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $serviceRequest = ServiceRequest::create([
                'veiculo_id' => $request->veiculo_id,
                'motorista_id' => $request->motorista_id,
                'tipo' => $request->tipo,
                'data' => $request->data,
                'hora' => $request->hora,
                'observacao' => $request->observacao,
                'km' => $request->km,
                'valor' => $request->valor,
                'status' => 'AGENDADO'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Solicitação de serviço criada com sucesso',
                'data' => $serviceRequest->load(['veiculo', 'motorista'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibir solicitação de serviço específica
     */
    public function show($id): JsonResponse
    {
        try {
            $serviceRequest = ServiceRequest::with(['veiculo', 'user'])->find($id);

            if (!$serviceRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solicitação de serviço não encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $serviceRequest
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualizar solicitação de serviço
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'veiculo_id' => 'sometimes|exists:veiculos,id',
            'user_id' => 'sometimes|exists:users,id',
            'type' => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
            'priority' => 'sometimes|in:baixa,media,alta,critica',
            'status' => 'sometimes|in:pendente,em_andamento,concluido,cancelado',
            'scheduled_date' => 'nullable|date',
            'completed_date' => 'nullable|date',
            'estimated_cost' => 'nullable|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $serviceRequest = ServiceRequest::find($id);

            if (!$serviceRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solicitação de serviço não encontrada'
                ], 404);
            }

            // Se o status está sendo alterado para 'concluido', definir data de conclusão
            if ($request->has('status') && $request->status === 'concluido' && !$serviceRequest->completed_date) {
                $request->merge(['completed_date' => Carbon::now()]);
            }

            $serviceRequest->update($request->only([
                'veiculo_id', 'user_id', 'type', 'description', 'priority', 'status',
                'scheduled_date', 'completed_date', 'estimated_cost', 'actual_cost', 'notes'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Solicitação de serviço atualizada com sucesso',
                'data' => $serviceRequest->load(['veiculo', 'user'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Excluir solicitação de serviço
     */
    public function destroy($id): JsonResponse
    {
        try {
            $serviceRequest = ServiceRequest::find($id);

            if (!$serviceRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solicitação de serviço não encontrada'
                ], 404);
            }

            // Verificar se a solicitação pode ser excluída (não está em andamento)
            if ($serviceRequest->status === 'em_andamento') {
                return response()->json([
                    'success' => false,
                    'message' => 'Não é possível excluir solicitação em andamento'
                ], 400);
            }

            $serviceRequest->delete();

            return response()->json([
                'success' => true,
                'message' => 'Solicitação de serviço excluída com sucesso'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obter estatísticas de serviços
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total' => ServiceRequest::count(),
                'pendente' => ServiceRequest::where('status', 'pendente')->count(),
                'em_andamento' => ServiceRequest::where('status', 'em_andamento')->count(),
                'concluido' => ServiceRequest::where('status', 'concluido')->count(),
                'cancelado' => ServiceRequest::where('status', 'cancelado')->count(),
                'por_prioridade' => [
                    'baixa' => ServiceRequest::where('priority', 'baixa')->count(),
                    'media' => ServiceRequest::where('priority', 'media')->count(),
                    'alta' => ServiceRequest::where('priority', 'alta')->count(),
                    'critica' => ServiceRequest::where('priority', 'critica')->count()
                ],
                'custo_total_estimado' => ServiceRequest::sum('estimated_cost'),
                'custo_total_real' => ServiceRequest::whereNotNull('actual_cost')->sum('actual_cost')
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
