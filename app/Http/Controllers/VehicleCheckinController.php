<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehicleCheckin;
use App\Models\VehicleCheckout;
use App\Models\Veiculo;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class VehicleCheckinController extends Controller
{
    /**
     * Realizar check-in de veículo
     */
    public function checkin(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:veiculos,id',
            'user_id' => 'required|exists:users,id',
            'qrCode' => 'required|string',
            'odometer' => 'required|integer|min:0',
            'fuelLevel' => 'required|integer|min:0|max:100',
            'location' => 'nullable|string|max:255',
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
            // Verificar se o veículo está disponível
            $vehicle = Veiculo::find($request->vehicle_id);
            if ($vehicle->status !== 'disponivel') {
                return response()->json([
                    'success' => false,
                    'message' => 'Veículo não está disponível para check-in'
                ], 400);
            }

            // Criar registro de check-in
            $checkin = VehicleCheckin::create([
                'vehicle_id' => $request->vehicle_id,
                'user_id' => $request->user_id,
                'qrCode' => $request->qrCode,
                'odometer' => $request->odometer,
                'fuelLevel' => $request->fuelLevel,
                'location' => $request->location,
                'notes' => $request->notes,
                'timestamp' => Carbon::now()
            ]);

            // Atualizar status do veículo para 'em uso'
            $vehicle->update([
                'status' => 'em_uso',
                'currentUserId' => $request->user_id,
                'odometer' => $request->odometer,
                'fuelLevel' => $request->fuelLevel
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-in realizado com sucesso',
                'data' => $checkin->load(['vehicle', 'user'])
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
     * Realizar check-out de veículo
     */
    public function checkout(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:veiculos,id',
            'user_id' => 'required|exists:users,id',
            'qrCode' => 'required|string',
            'odometer' => 'required|integer|min:0',
            'fuelLevel' => 'required|integer|min:0|max:100',
            'location' => 'nullable|string|max:255',
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
            // Verificar se o veículo está em uso pelo usuário
            $vehicle = Veiculo::find($request->vehicle_id);
            if ($vehicle->status !== 'em_uso' || $vehicle->currentUserId != $request->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Veículo não está em uso por este usuário'
                ], 400);
            }

            // Criar registro de check-out
            $checkout = VehicleCheckout::create([
                'vehicle_id' => $request->vehicle_id,
                'user_id' => $request->user_id,
                'qrCode' => $request->qrCode,
                'odometer' => $request->odometer,
                'fuelLevel' => $request->fuelLevel,
                'location' => $request->location,
                'notes' => $request->notes,
                'timestamp' => Carbon::now()
            ]);

            // Atualizar status do veículo para 'disponível'
            $vehicle->update([
                'status' => 'disponivel',
                'currentUserId' => null,
                'odometer' => $request->odometer,
                'fuelLevel' => $request->fuelLevel
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-out realizado com sucesso',
                'data' => $checkout->load(['vehicle', 'user'])
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
     * Listar histórico de check-ins
     */
    public function checkinHistory(Request $request): JsonResponse
    {
        try {
            $query = VehicleCheckin::with(['vehicle', 'user']);

            // Filtros opcionais
            if ($request->has('vehicle_id')) {
                $query->where('vehicle_id', $request->vehicle_id);
            }

            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->has('date_from')) {
                $query->whereDate('timestamp', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('timestamp', '<=', $request->date_to);
            }

            $checkins = $query->orderBy('timestamp', 'desc')
                            ->paginate($request->get('per_page', 15));

            return response()->json([
                'success' => true,
                'data' => $checkins
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
     * Listar histórico de check-outs
     */
    public function checkoutHistory(Request $request): JsonResponse
    {
        try {
            $query = VehicleCheckout::with(['vehicle', 'user']);

            // Filtros opcionais
            if ($request->has('vehicle_id')) {
                $query->where('vehicle_id', $request->vehicle_id);
            }

            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->has('date_from')) {
                $query->whereDate('timestamp', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('timestamp', '<=', $request->date_to);
            }

            $checkouts = $query->orderBy('timestamp', 'desc')
                             ->paginate($request->get('per_page', 15));

            return response()->json([
                'success' => true,
                'data' => $checkouts
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
