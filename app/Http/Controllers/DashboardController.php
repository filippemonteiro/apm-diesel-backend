<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
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
                    'total_clientes' => 0,
                    'total_usuarios' => 0,
                    'total_carros' => 0,
                    'total_horarios' => 0,
                    'total_rotas' => 0,
                ]
            ]);
            
           
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);

        }
    }
}