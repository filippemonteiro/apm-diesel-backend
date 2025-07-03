<?php

namespace App\Services;

use App\Models\Servico as Model;
use Exception;

class ServicosServices extends BaseServices 
{
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->indexOptions = [
            'value' => 'id',
            'label' => 'tipo',
        ];
        $this->columnSearch = 'tipo';
        $this->orderBy = 'desc';
    }

    public function index($request) 
    {
        $params = $request->all();
        $this->user = $request->user();
        
        $data = $this->model
            ->with(['motorista', 'veiculo'])
            ->when($params, function($query, $params) {
                if(isset($params['search'])) {
                    $query->where('tipo', 'like', "%{$params['search']}%")
                          ->orWhereHas('motorista', function($q) use ($params) {
                              $q->where('name', 'like', "%{$params['search']}%");
                          })
                          ->orWhereHas('veiculo', function($q) use ($params) {
                              $q->where('marca', 'like', "%{$params['search']}%")
                                ->orWhere('modelo', 'like', "%{$params['search']}%");
                          });
                }

                if(isset($params['tipo'])) {
                    $query->where('tipo', $params['tipo']);
                }

                if(isset($params['motorista_id'])) {
                    $query->where('motorista_id', $params['motorista_id']);
                }

                if(isset($params['veiculo_id'])) {
                    $query->where('veiculo_id', $params['veiculo_id']);
                }

                return $query;
            })
            ->when($this->orderBy, function($query, $orderBy) {
                if($orderBy === 'desc') {
                    return $query->orderBy('data', 'desc')->orderBy('hora', 'desc');
                }
                return $query->orderBy('data', 'asc')->orderBy('hora', 'asc');
            })
            ->paginate(10);

        foreach($data as $item) {
            $item->valor_formatado;
            $item->data_hora;
        }

        return $this->response($data);
    }

    public function show($id) 
    {
        $data = $this->model->with(['motorista', 'veiculo'])->find($id);
        return response()->json(['data' => $data]);
    }

    public function beforeCreateData($data)
    {
        if(empty($data['tipo'])) {
            throw new Exception("O campo Tipo é obrigatório.");
        }

        if(empty($data['data'])) {
            throw new Exception("O campo Data é obrigatório.");
        }

        if(empty($data['hora'])) {
            throw new Exception("O campo Hora é obrigatório.");
        }

        if(empty($data['motorista_id'])) {
            throw new Exception("O campo Motorista é obrigatório.");
        }

        if(empty($data['veiculo_id'])) {
            throw new Exception("O campo Veículo é obrigatório.");
        }

        return $data;
    }

    public function beforeUpdateData($data)
    {
        if(empty($data['tipo'])) {
            throw new Exception("O campo Tipo é obrigatório.");
        }

        if(empty($data['data'])) {
            throw new Exception("O campo Data é obrigatório.");
        }

        if(empty($data['hora'])) {
            throw new Exception("O campo Hora é obrigatório.");
        }

        if(empty($data['motorista_id'])) {
            throw new Exception("O campo Motorista é obrigatório.");
        }

        if(empty($data['veiculo_id'])) {
            throw new Exception("O campo Veículo é obrigatório.");
        }

        return $data;
    }
}