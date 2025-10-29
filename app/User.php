<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject
{
    use HasApiTokens, Notifiable;


    const STATUS_ATIVO = 1;
    const STATUS_INATIVO = 0;

    const ROLE_ADMIN = 1; // Admin
    const ROLE_MOTORISTA = 2; // Motorista

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role', 
        'ativo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getTypeRole($type) {
        $list =  [
            1 => 'Administrador',
            2 => 'Motorista'
        ];
        return isset($list[$type])? $list[$type] : 'Desconhecido';
    }

    public static function getTypes() {
        $list =  [
            1 => 'Administrador',
            2 => 'Motorista'
        ];
        return $list;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email
         ];
    }

}
