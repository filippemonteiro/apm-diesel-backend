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
        'combustivel',
        'status'
        // 'currentUserId',
        // 'odometer',
        // 'fuelLevel',
        // 'qrCode'
    ];

    protected $casts = [
        'km' => 'integer',
        // 'currentUserId' => 'integer',
        // 'odometer' => 'integer',
        // 'fuelLevel' => 'integer'
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

    public function checkins()
    {
        // return $this->hasMany(VehicleCheckin::class, 'vehicle_id');
    }

    public function checkouts()
    {
        return $this->hasMany(VehicleCheckout::class, 'vehicle_id');
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'veiculo_id');
    }

    // Accessors
    public function getDescricaoCompletaAttribute()
    {
        return $this->marca . ' ' . $this->modelo . ' - ' . $this->cor;
    }
}