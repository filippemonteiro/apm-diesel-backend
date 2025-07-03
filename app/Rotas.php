<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rotas extends Model
{
    protected $table = "rotas";
    
    protected $fillable = [
        'nome',
        'motorista_id',
        'horario_id',
        'cidade_id'
    ];

    public function motorista()
    {
        return $this->belongsTo(User::class, 'motorista_id');
    }

    public function horario()
    {
        return $this->belongsTo(Horarios::class, 'horario_id');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidades::class, 'cidade_id');
    }
}
