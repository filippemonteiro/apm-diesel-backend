<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    /**
     * Simular login sem banco de dados
     */
    public function mockLogin(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');
        
        // Simular validação básica
        if ($email === 'admin@admin.com' && $password === '123456') {
            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso',
                'data' => [
                    'user' => [
                        'id' => 1,
                        'name' => 'Admin User',
                        'email' => 'admin@admin.com',
                        'role' => 'admin'
                    ],
                    'token' => 'mock_token_' . time()
                ]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Credenciais inválidas'
        ], 401);
    }
    
    /**
     * Simular listagem de veículos
     */
    public function mockVeiculos(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                [
                    'id' => 1,
                    'marca' => 'Toyota',
                    'modelo' => 'Corolla',
                    'placa' => 'ABC1234',
                    'ano' => 2020,
                    'cor' => 'Branco',
                    'km' => 50000,
                    'combustivel' => 'Flex',
                    'status' => 'disponivel'
                ],
                [
                    'id' => 2,
                    'marca' => 'Honda',
                    'modelo' => 'Civic',
                    'placa' => 'DEF5678',
                    'ano' => 2021,
                    'cor' => 'Preto',
                    'km' => 30000,
                    'combustivel' => 'Flex',
                    'status' => 'disponivel'
                ]
            ]
        ]);
    }
    
    /**
     * Simular check-in
     */
    public function mockCheckin(Request $request): JsonResponse
    {
        $qrCode = $request->input('qrCode');
        $motoristaId = $request->input('motorista_id');
        
        if (!$qrCode || !$motoristaId) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code e ID do motorista são obrigatórios'
            ], 400);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Check-in realizado com sucesso',
            'data' => [
                'reserva_id' => rand(1, 1000),
                'veiculo' => [
                    'id' => 1,
                    'marca' => 'Toyota',
                    'modelo' => 'Corolla',
                    'placa' => $qrCode
                ],
                'data_hora_checkin' => now()->toISOString()
            ]
        ]);
    }
    
    /**
     * Simular checkout
     */
    public function mockCheckout(Request $request): JsonResponse
    {
        $qrCode = $request->input('qrCode');
        $kmFinal = $request->input('km_final');
        
        if (!$qrCode || !$kmFinal) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code e quilometragem final são obrigatórios'
            ], 400);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Check-out realizado com sucesso',
            'data' => [
                'reserva_id' => rand(1, 1000),
                'veiculo' => [
                    'id' => 1,
                    'marca' => 'Toyota',
                    'modelo' => 'Corolla',
                    'placa' => $qrCode
                ],
                'data_hora_checkout' => now()->toISOString(),
                'duracao_minutos' => rand(30, 480)
            ]
        ]);
    }
    
    /**
     * Simular busca de veículo por QR Code
     */
    public function mockQrCodeVehicle(Request $request): JsonResponse
    {
        $qrCode = $request->input('qrCode');
        
        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code é obrigatório'
            ], 400);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => 1,
                'marca' => 'Toyota',
                'modelo' => 'Corolla',
                'placa' => $qrCode,
                'ano' => 2020,
                'cor' => 'Branco',
                'km' => 50000,
                'combustivel' => 'Flex',
                'status' => 'disponivel'
            ]
        ]);
    }
}