<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QrCodeController extends Controller
{
    /**
     * Buscar veículo por QR Code
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qrCode' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code é obrigatório',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buscar veículo pelo QR Code
            $veiculo = Veiculo::where('qrCode', $request->qrCode)
                ->orWhere('placa', $request->qrCode)
                ->first();
            
            if (!$veiculo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Veículo não encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $veiculo->id,
                    'marca' => $veiculo->marca,
                    'modelo' => $veiculo->modelo,
                    'placa' => $veiculo->placa,
                    'ano' => $veiculo->ano,
                    'cor' => $veiculo->cor,
                    'km' => $veiculo->km,
                    'combustivel' => $veiculo->combustivel,
                    'status' => $veiculo->status,
                    'observacao' => $veiculo->observacao,
                    'observacoes' => $veiculo->observacoes,
                    'currentUserId' => $veiculo->currentUserId,
                    'odometer' => $veiculo->odometer,
                    'fuelLevel' => $veiculo->fuelLevel,
                    'qrCode' => $veiculo->qrCode
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}