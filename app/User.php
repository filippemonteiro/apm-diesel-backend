<?php

namespace App;

use App\Models\Colaborador;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject
{
    use HasApiTokens, Notifiable;


    const STATUS_ATIVO = 1;
    const STATUS_INATIVO = 0;

    const ROLE_ADMIN = 1;
    const ROLE_ALUNO = 2;


    const SUPERADMIN = 1;
    const ADMINISTRADOR = 2;
    const OPERADOR = 3;
    const MOTORISTA = 4;
    const PUBLICO = 5;

   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'cpf',
        'password', 
        'role', 
        'role_chamados',
        'ativo', 
        'cidade_id', 
        'colaborador_id'
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
            1 => 'SuperAdmin',
            2 => 'Administrador',
            3 => 'Operador',
            4 => 'Motorista',
            5 => 'Publico'
        ];
        return isset($list[$type])? $list[$type] : 'Desconhecido';
    }

    public static function getTypes() {
        $list =  [
            1 => 'SuperAdmin',
            2 => 'Administrador',
            3 => 'Operador',
            4 => 'Motorista',
            5 => 'Publico'
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

    public function cidade() {
        return $this->belongsTo(Cidades::class, 'cidade_id');
    }
}
