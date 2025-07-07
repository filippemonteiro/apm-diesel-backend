<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidades extends Model
{
    protected $table = "cidades";
    
    protected $fillable = [
        'nome',
        'estado_id'
    ];

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'estado_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'cidade_id');
    }
}
