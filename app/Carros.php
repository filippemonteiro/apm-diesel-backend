<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carros extends Model
{
    protected $table = "carros";
    
    protected $fillable = [
        'nome',
        'modelo',
        'placa',
        'ano',
        'cidade_id'
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidades::class, 'cidade_id');
    }
}
