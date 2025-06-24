<?php
namespace App\Services;

use App\Models\Permissao as Model;

class PermissoesServices extends BaseServices {
    
    public function __construct(Model $model)
    {
        $this->columnSearch = 'name';
        $this->model = $model;
    }

    public function index($request) {
        $params = $request->all();

        $data = $this->model->when($params, function($query, $params) {
            if(isset($params['search'])) {
                $query->where($this->columnSearch, 'like', "%{$params['search']}%");
            }
            return $query;
        })
        ->when($this->orderBy, function($query, $orderBy) {
            if($orderBy === 'desc') {
                return $query->orderBy('id', 'desc');
            }
        })
        ->paginate(10);

        foreach($data as $item) {
            $item->user_name = $item->user->name;
        }
        return $this->response($data);
    }

    public function beforeCreateData($data)
    {
        $data['data'] = json_encode($data['data']);
        return $data;
    }

    public function beforeUpdateData($data)
    {
        $data['data'] = json_encode($data['data']);
        return $data;
    }

}