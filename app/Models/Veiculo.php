<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $table = "veiculos";
    
    protected $fillable = [
        'marca',
        'modelo',
        'placa',
        'ano',
        'cor',
        'km',
        'observacao',
        'observacoes',
        'combustivel'
    ];

    protected $casts = [
        'km' => 'integer'
    ];

    // Relacionamentos
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'veiculo_id');
    }

    public function servicos()
    {
        return $this->hasMany(Servico::class, 'veiculo_id');
    }

    // Accessors
    public function getDescricaoCompletaAttribute()
    {
        return $this->marca . ' ' . $this->modelo . ' - ' . $this->cor;
    }
}