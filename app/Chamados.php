<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chamados extends Model
{
    protected $table = "chamados";
    
    protected $fillable = [
        'status',
        'tipos_chamado_id',
        'descricao',
        'observacao',
        'path',
        'prioridade',
        'cidade_id',
        'criado_por',
        'requerido_por'
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidades::class, 'cidade_id');
    }

    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'criado_por');
    }
}
