<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'service_requests';

    protected $fillable = [
        'tipo',
        'data',
        'hora',
        'observacao',
        'km',
        'valor',
        'status',
        'veiculo_id',
        'motorista_id'
    ];

    protected $casts = [
        'data' => 'date',
        'hora' => 'datetime:H:i',
        'valor' => 'decimal:2'
    ];

    // Relacionamentos
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'veiculo_id');
    }

    public function motorista()
    {
        return $this->belongsTo(User::class, 'motorista_id');
    }
}
