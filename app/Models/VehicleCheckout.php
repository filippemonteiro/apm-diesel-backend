<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class VehicleCheckout extends Model
{
    use HasFactory;

    protected $table = 'vehicle_checkouts';

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'qrCode',
        'odometer',
        'fuelLevel',
        'location',
        'notes',
        'timestamp'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'odometer' => 'integer',
        'fuelLevel' => 'integer'
    ];

    // Relacionamentos
    public function vehicle()
    {
        return $this->belongsTo(Veiculo::class, 'vehicle_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
