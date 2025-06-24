<?php
namespace App\Services;

use App\Cidades;
use App\User as Model;
use Exception;
use Illuminate\Support\Facades\Hash;

class UsersServices extends BaseServices {
   
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->indexOptions = [
            'value' => 'id',
            'label' => 'name',
        ];
        $this->columnSearch = 'name';
    }

    public function index($request) {
        $params = $request->all();
        $this->user = $request->user();
        $data = $this->model->when($this->orderBy, function($query, $orderBy) {
            if($this->user->role != Model::SUPERADMIN) {
                $query->where('cidade_id', $this->user->cidade_id);
            }

            if($this->user->role == Model::ADMINISTRADOR) {
                $query->whereIn('role', [Model::ADMINISTRADOR, Model::OPERADOR, Model::MOTORISTA, Model::PUBLICO]);
            }

            if($this->user->role == Model::OPERADOR) {
                $query->whereIn('role', [Model::OPERADOR, Model::MOTORISTA, Model::PUBLICO]);
            }

            if($this->user->role == Model::MOTORISTA) {
                $query->whereIn('role', [Model::MOTORISTA]);
            }

            return $query;
        })->paginate(10);

        foreach($data as $item) {
            $item->cidade = null;
            if($item->cidade_id) {
                $item->cidade = Cidades::find($item->cidade_id);
            }
            if($item->ativo) {
                $item->ativo_f = "Ativo";
            } else {
                $item->ativo_f = "Inativo";
            }
        }
        return $this->response($data);
    }

    public function beforeCreateData($data)
    {

        $userExists = Model::where('email', $data['email'])->first();
        if($userExists) {
            throw new Exception("E-mail já cadastrado.");
        }

        $data['password'] = Hash::make($data['password']);
        return $data;
    }

    public function beforeUpdateData($data)
    {
        if(isset($data['password']) && !empty($data['password'])) {
            if(!isset($data['password_confirmation'])) {
                throw new Exception("O campo *Confirmação de Senha* está diferente do campo Senha.");
            }
            if($data['password'] != $data['password_confirmation']) {
                throw new Exception("O campo *Confirmação de Senha* está diferente do campo Senha.");
            }
            $data['password'] = Hash::make($data['password']);
            return $data;    
        } else {
            unset($data['password_confirmation']);
            unset($data['password']);
        }
        return $data;
    }

}