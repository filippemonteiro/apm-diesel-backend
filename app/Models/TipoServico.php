<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServico extends Model
{
    protected $table = "tipos_servicos";
    
    protected $fillable = [
        'descricao',
        'observacao'
    ];
}