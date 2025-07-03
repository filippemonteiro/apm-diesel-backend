<?php

namespace App\Services;

use App\Models\TipoServico as Model;
use Exception;

class TiposServicosServices extends BaseServices 
{
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->indexOptions = [
            'value' => 'id',
            'label' => 'descricao',
        ];
        $this->columnSearch = 'descricao';
        $this->orderBy = 'asc';
    }

    public function index($request) 
    {
        $params = $request->all();
        $this->user = $request->user();
        
        $data = $this->model
            ->when($params, function($query, $params) {
                if(isset($params['search'])) {
                    $query->where('descricao', 'like', "%{$params['search']}%");
                }
                return $query;
            })
            ->when($this->orderBy, function($query, $orderBy) {
                if($orderBy === 'desc') {
                    return $query->orderBy('id', 'desc');
                }
                return $query->orderBy('descricao', 'asc');
            })
            ->paginate(10);

        return $this->response($data);
    }

    public function beforeCreateData($data)
    {
        if(empty($data['descricao'])) {
            throw new Exception("O campo Descrição é obrigatório.");
        }

        return $data;
    }

    public function beforeUpdateData($data)
    {
        if(empty($data['descricao'])) {
            throw new Exception("O campo Descrição é obrigatório.");
        }

        return $data;
    }
}
