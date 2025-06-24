<?php
namespace App\Http\Controllers;

use App\Carros;
use App\Horarios;
use App\Http\Controllers\Controller;
use App\Models\Adverts;
use App\Models\ImportsAdverts;
use App\Models\Pedido;
use App\Models\Products;
use App\Rotas;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class DashboardController extends Controller {

    public function __construct() {
    }

    /**
    * @Route("/dashboard/totais")
    */
    public function totais(Request $request) {
        try {    
            $user = $request->user();

            return response()->json([
                'data' => [
                    'total_clientes' => User::where('role', User::ADMINISTRADOR)->get()->count(),
                    'total_usuarios' => User::when($user, function($query, $user) { 
                        if($user->role != User::SUPERADMIN) {
                            $query->where('cidade_id', $user->cidade_id);
                        }
                        return $query;
                     })->get()->count(),
                    'total_carros' => Carros::when($user, function($query, $user) { 
                        if($user->role != User::SUPERADMIN) {
                            $query->where('cidade_id', $user->cidade_id);
                        }
                        return $query;
                     })->get()->count(),
                    'total_horarios' => Horarios::when($user, function($query, $user) { 
                        if($user->role != User::SUPERADMIN) {
                            $query->where('cidade_id', $user->cidade_id);
                        }
                        return $query;
                     })->get()->count(),
                    'total_rotas' => Rotas::when($user, function($query, $user) { 
                        if($user->role != User::SUPERADMIN) {
                            $query->where('cidade_id', $user->cidade_id);
                        }
                        return $query;
                     })->get()->count(),
                ]
            ]);
            
           
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);

        }
    }
}