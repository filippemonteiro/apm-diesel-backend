<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    protected $table = "estados";
    
    protected $fillable = [
        'nome'
    ];

    public function cidades()
    {
        return $this->hasMany(Cidades::class, 'estado_id');
    }
}
