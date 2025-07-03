<?php

namespace App\Services;

use App\Models\Veiculo as Model;
use Exception;

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

        return $data;
    }

    public function beforeUpdateData($data)
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

        return $data;
    }
}