<?php
namespace App\Helpers;

class Helpers {

    public static function messageValidation($field, $type, $q = '') {
        $list = [
            'required' => "O campo {$field} é obrigatório.",
            'min' => "O campo {$field} aceita no mínimo {$q} caracteres.",
            'max' => "O campo {$field} aceita no mínimo {$q} caracteres.",
            'email' => "O e-mail é inválido no campo {$field}.",
            'unique' => "Já existe um registro na base de dados do campo {$field}."
        ];

        return $list[$type];
    }

    public static function issetNotEmpty($params, $name) {
        if(isset($params[$name]) && !empty($params[$name])) {
            return true;
        }
        return false; 
    }

    public static function  formatCnpjCpf($value) {
        $CPF_LENGTH = 11;
        $cnpj_cpf = preg_replace("/\D/", '', $value);
    
        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        } 
    
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }

}