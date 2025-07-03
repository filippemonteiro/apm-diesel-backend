<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Reserva extends Model
{
    protected $table = "reservas";
    
    protected $fillable = [
        'data_hora_checkin',
        'data_hora_checkout',
        'motorista_id',
        'veiculo_id',
        'km',
        'observacao'
    ];

    protected $casts = [
        'data_hora_checkin' => 'datetime',
        'data_hora_checkout' => 'datetime',
        'km' => 'integer'
    ];

    protected $dates = [
        'data_hora_checkin',
        'data_hora_checkout'
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
    public function getDuracaoAttribute()
    {
        if ($this->data_hora_checkout) {
            return $this->data_hora_checkin->diffInHours($this->data_hora_checkout);
        }
        return null;
    }
}