<?php

namespace App\Services;

use App\Models\Reserva as Model;
use Carbon\Carbon;
use Exception;

class ReservasServices extends BaseServices 
{
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->indexOptions = [
            'value' => 'id',
            'label' => 'id',
        ];
        $this->columnSearch = 'id';
        $this->orderBy = 'desc';
    }

    public function checkIn($request) {
        try{
            DB::beginTransaction();
            $this->user = $request->user();

            $request->validate([
                'motorista_id' => 'required',
                'veiculo_id' => 'required',
                'km' => 'required'
            ]);
            
            $params['data_hora_checkin'] = Carbon::now()->setTimezone('America/Sao_Paulo')->format('d-m-Y H:i:s');
            $data = $this->model->create($params);
      
            $data = $this->sanitizeDataCreate($data);
            DB::commit();
            return $this->response(['message' => 'CheckIn Realizado com Sucesso', 'data' => $data]);
            
        } catch(Exception $e) {
            DB::rollBack();
            return $this->response(['message' => $e->getMessage()], 500);
        }
    }

     public function checkOut($request) {
        try{
            DB::beginTransaction();
            $this->user = $request->user();
            
            $request->validate([
                'id' => 'required',
                'km' => 'required'
            ]);
            $data = $this->model->find($params['id']);
            $params['data_hora_checkout'] = Carbon::now()->setTimezone('America/Sao_Paulo')->format('d-m-Y H:i:s');
            $data = $data->update($params);
    
            $data = $this->sanitizeDataCreate($data);
            DB::commit();
            return $this->response(['message' => 'CheckOut Realizado com Sucesso', 'data' => $data]);
            
        } catch(Exception $e) {
            DB::rollBack();
            return $this->response(['message' => $e->getMessage()], 500);
        }
    }
    public function index($request) 
    {
        $params = $request->all();
        $this->user = $request->user();
        
        $data = $this->model
            ->with(['motorista', 'veiculo'])
            ->when($params, function($query, $params) {
                if(isset($params['search'])) {
                    $query->whereHas('motorista', function($q) use ($params) {
                        $q->where('name', 'like', "%{$params['search']}%");
                    })->orWhereHas('veiculo', function($q) use ($params) {
                        $q->where('marca', 'like', "%{$params['search']}%")
                        ->orWhere('modelo', 'like', "%{$params['search']}%");
                    });
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
                    return $query->orderBy('data_hora_checkin', 'desc');
                }
                return $query->orderBy('data_hora_checkin', 'asc');
            })
            ->paginate(10);

        foreach($data as $item) {
            $item->duracao;
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
        if(empty($data['motorista_id'])) {
            throw new Exception("O campo Motorista é obrigatório.");
        }

        if(empty($data['veiculo_id'])) {
            throw new Exception("O campo Veículo é obrigatório.");
        }

        $dataHora = Carbon::now()->setTimezone('America/Sao_Paulo')->format('Y-m-d H:i:s');
        $data['data_hora_checkin'] = $dataHora;

        return $data;

    }

    public function beforeUpdateData($data)
    {
        
        if(empty($data['motorista_id'])) {
            throw new Exception("O campo Motorista é obrigatório.");
        }

        if(empty($data['veiculo_id'])) {
            throw new Exception("O campo Veículo é obrigatório.");
        }

        return $data;
    }
}
