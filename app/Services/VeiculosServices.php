<?php

namespace App\Services;

use App\Models\Veiculo as Model;
use Exception;
use Illuminate\Support\Facades\Log;

class VeiculosServices extends BaseServices 
{
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->indexOptions = [
            'value' => 'id',
            'label' => 'descricao_completa',
        ];
        $this->columnSearch = 'marca';
        $this->orderBy = 'asc';
    }

    public function index($request) 
    {
        $params = $request->all();
        $this->user = $request->user();
        
        $data = $this->model
            ->select(['id', 'marca', 'modelo', 'placa', 'ano', 'cor', 'km', 'combustivel', 'status', 'observacao', 'observacoes', 'currentUserId', 'odometer', 'fuelLevel', 'qrCode', 'created_at', 'updated_at'])
            ->when($params, function($query, $params) {
                if(isset($params['search'])) {
                    $query->where(function($q) use ($params) {
                        $q->where('marca', 'like', "%{$params['search']}%")
                        ->orWhere('modelo', 'like', "%{$params['search']}%")
                        ->orWhere('cor', 'like', "%{$params['search']}%");
                    });
                }
                return $query;
            })
            ->when($this->orderBy, function($query, $orderBy) {
                if($orderBy === 'desc') {
                    return $query->orderBy('id', 'desc');
                }
                return $query->orderBy('marca', 'asc');
            })
            ->paginate(10);

        foreach($data as $item) {
            $item->descricao_completa;
        }

        return $this->response($data);
    }

    public function show($id) 
    {
        $data = $this->model->with(['reservas.motorista', 'servicos'])
                        ->find($id);
        return response()->json(['data' => $data]);
    }

    public function beforeCreateData($data)
    {
        if(empty($data['marca'])) {
            throw new Exception("O campo Marca é obrigatório.");
        }

        if(empty($data['modelo'])) {
            throw new Exception("O campo Modelo é obrigatório.");
        }

        if(empty($data['cor'])) {
            throw new Exception("O campo Cor é obrigatório.");
        }

        if(empty($data['placa'])) {
            throw new Exception("O campo Placa é obrigatório.");
        }

        if(empty($data['ano'])) {
            throw new Exception("O campo Ano é obrigatório.");
        }

        if(empty($data['qrCode'])) {
            throw new Exception("O campo QR Code é obrigatório.");
        }

        // Verificar se a placa já existe
        $existingVeiculo = $this->model->where('placa', $data['placa'])->first();
        if($existingVeiculo) {
            throw new Exception("Já existe um veículo cadastrado com esta placa.");
        }

        return $data;
    }

    public function beforeUpdateData($data)
    {
        // Log detalhado para debug
        Log::error('=== DEBUG ATUALIZAÇÃO VEÍCULO ===');
        Log::error('Dados brutos recebidos: ' . json_encode($data));
        Log::error('Tipo de dados: ' . gettype($data));
        Log::error('Chaves disponíveis: ' . json_encode(array_keys($data)));
        Log::error('Valor marca: ' . json_encode($data['marca'] ?? 'CHAVE_NAO_EXISTE'));
        Log::error('Marca está vazia? ' . (empty($data['marca']) ? 'SIM' : 'NÃO'));
        Log::error('================================');
        
        if (empty($data['marca'])) {
            throw new \Exception('O campo Marca é obrigatório.');
        }
        
        if (empty($data['modelo'])) {
            throw new \Exception('O campo Modelo é obrigatório.');
        }
        
        if (empty($data['cor'])) {
            throw new \Exception('O campo Cor é obrigatório.');
        }
        
        if (empty($data['placa'])) {
            throw new \Exception('O campo Placa é obrigatório.');
        }
        
        if (empty($data['ano'])) {
            throw new \Exception('O campo Ano é obrigatório.');
        }
        
        // Verificar se já existe um veículo com a mesma placa (exceto o atual)
        $existingVehicle = $this->model->where('placa', $data['placa'])
                                      ->where('id', '!=', $data['id'] ?? 0)
                                      ->first();
        
        if ($existingVehicle) {
            throw new \Exception('Já existe um veículo cadastrado com esta placa.');
        }
        
        return $data;
    }
}
