<?php

namespace App\Services;

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
        
        $data = $this->model
            ->when($params, function($query, $params) {
                if(isset($params['search'])) {
                    $query->where('name', 'like', "%{$params['search']}%")
                        ->orWhere('email', 'like', "%{$params['search']}%");
                }
                return $query;
            })
            ->when($this->orderBy, function($query, $orderBy) {
                if($orderBy === 'desc') {
                    return $query->orderBy('id', 'desc');
                }
                return $query->orderBy('name', 'asc');
            })
            ->paginate(10);

        return $this->response($data);
    }

    public function beforeCreateData($data)
    {
        $userExists = Model::where('email', $data['email'])->first();
        if($userExists) {
            throw new Exception("E-mail já cadastrado.");
        }

        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        return $data;
    }

    public function beforeUpdateData($data)
    {
        if(isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        
        return $data;
    }
}