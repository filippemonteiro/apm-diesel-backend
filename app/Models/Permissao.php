<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    protected $table = "permissoes";
    protected $fillable = [
        'id',
        'user_id',
        'data'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
