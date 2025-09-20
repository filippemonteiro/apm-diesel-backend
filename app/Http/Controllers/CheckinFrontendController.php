<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CheckinFrontendController extends Controller
{
    /**
     * Realizar check-in de veículo (compatível com frontend)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qrCode' => 'required|string',
            'quilometragemAtual' => 'required|integer|min:0',
            'nivelCombustivel' => 'required|integer|min:0|max:100',
            'localRetirada' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
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

            // Verificar se o veículo já está em uso
            $reservaAtiva = Reserva::where('veiculo_id', $veiculo->id)
                ->whereNull('data_hora_checkout')
                ->first();

            if ($reservaAtiva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Veículo já está em uso'
                ], 400);
            }

            // Criar nova reserva (check-in)
            $reserva = Reserva::create([
                'data_hora_checkin' => Carbon::now(),
                'motorista_id' => Auth::id(),
                'veiculo_id' => $veiculo->id,
                'km' => $request->quilometragemAtual,
                'observacao' => $request->observacoes ?? ''
            ]);

            // Atualizar status e dados do veículo
            $veiculo->update([
                'status' => 'em_uso',
                'currentUserId' => Auth::id(),
                'odometer' => $request->quilometragemAtual,
                'fuelLevel' => $request->nivelCombustivel
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-in realizado com sucesso',
                'data' => [
                    'reserva_id' => $reserva->id,
                    'veiculo' => $veiculo->marca . ' ' . $veiculo->modelo,
                    'placa' => $veiculo->placa,
                    'data_hora_checkin' => $reserva->data_hora_checkin->toISOString(),
                    'quilometragem' => $request->quilometragemAtual,
                    'combustivel' => $request->nivelCombustivel,
                    'local' => $request->localRetirada
                ]
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
     * Realizar check-out de veículo (compatível com frontend)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qrCode' => 'required|string',
            'quilometragemAtual' => 'required|integer|min:0',
            'nivelCombustivel' => 'required|integer|min:0|max:100',
            'localDevolucao' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
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

            // Buscar reserva ativa do usuário para este veículo
            $reserva = Reserva::where('veiculo_id', $veiculo->id)
                ->where('motorista_id', Auth::id())
                ->whereNull('data_hora_checkout')
                ->first();

            if (!$reserva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhuma reserva ativa encontrada para este veículo'
                ], 400);
            }

            // Atualizar reserva com dados do check-out
            $reserva->update([
                'data_hora_checkout' => Carbon::now(),
                'km' => $request->quilometragemAtual,
                'observacao' => ($reserva->observacao ?? '') . '\n' . ($request->observacoes ?? '')
            ]);

            // Atualizar status e dados do veículo
            $veiculo->update([
                'status' => 'disponivel',
                'currentUserId' => null,
                'odometer' => $request->quilometragemAtual,
                'fuelLevel' => $request->nivelCombustivel
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-out realizado com sucesso',
                'data' => [
                    'reserva_id' => $reserva->id,
                    'veiculo' => $veiculo->marca . ' ' . $veiculo->modelo,
                    'placa' => $veiculo->placa,
                    'data_hora_checkin' => $reserva->data_hora_checkin->toISOString(),
                    'data_hora_checkout' => $reserva->data_hora_checkout->toISOString(),
                    'duracao_horas' => $reserva->duracao,
                    'quilometragem' => $request->quilometragemAtual,
                    'combustivel' => $request->nivelCombustivel,
                    'local' => $request->localDevolucao
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