<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    protected $table = "horarios";
    
    protected $fillable = [
        'nome',
        'horario',
        'dia_da_semana',
        'observacao',
        'cidade_id'
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidades::class, 'cidade_id');
    }
}
