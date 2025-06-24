<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;

class AdvertRequest 
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($id = ''){
        return [
            'title' => 'required|min:3|max:60',
            // 'codigo' => 'required|unique:orgaos'.($id ? ',codigo,'.$id : ''),
            'description' => 'required|min:3',
            // "cbo_id" => 'required',
        ];
    }
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages(){
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'min' => 'O campo :attribute deve conter no mínimo :min caracteres.',
            'max' => 'O campo :attribute deve conter no máximo :max caracteres.',
            'unique' => 'O código informado já existe!'
        ];
    }
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function fields(){
        return [
            "title" => "Título",
            "description" => "Descrição",
        ];
    }
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function validation($request, $id = ''){
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->fields());
        return $validator;
    }
}
