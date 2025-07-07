<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Servico extends Model
{
    protected $table = "servicos";
    
    protected $fillable = [
        'tipo',
        'data',
        'hora',
        'observacao',
        'km',
        'valor',
        'motorista_id',
        'veiculo_id'
    ];

    protected $casts = [
        'data' => 'date',
        'hora' => 'datetime:H:i:s',
        'km' => 'integer',
        'valor' => 'decimal:2'
    ];

    protected $dates = [
        'data'
    ];

    // Relacionamentos
    public function motorista()
    {
        return $this->belongsTo(User::class, 'motorista_id');
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'veiculo_id');
    }

    // Accessors
    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

    public function getDataHoraAttribute()
    {
        return $this->data->format('d/m/Y') . ' às ' . $this->hora->format('H:i');
    }
}