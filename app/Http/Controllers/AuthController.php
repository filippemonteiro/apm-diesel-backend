<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Exception;
use DB;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'loginApp']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Login ou senha incorreto'], 500);
        }
        if($user->ativo == User::STATUS_INATIVO) {
            return response()->json(['message' => 'Este usuário encontra-se inativo.'], 500);
        }
        $token = $user->createToken($user->email)->plainTextToken;
        return response()->json([
            'token' => $token,
            'message' => 'Usuário logado com sucesso.',
            'user' => [
                'name' =>  $user->name
            ]
        ]);
    }

    public function loginApp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $user = User::where('email', $request->email)->first();
        if($user) {
            if(!in_array($user->role, ['1', '3'])) {
                throw new Exception("Usuário sem permissão. Por favor, entre em contato com o Administrador");
            }
        }
        

        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Login ou senha incorreto'], 500);
        }
        $token = $user->createToken($user->email)->plainTextToken;
        return response()->json([
            'token' => $token,
            'message' => 'Usuário logado com sucesso.'
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = $request->user();
        // $listaPermissoes = config('permissoes');
        $user = User::find($request->user()->id);
        // if($permissoes) {
        //     $listaPermissoes = $permissoes->data;
        // }
        // $user->permissoes = $listaPermissoes;
        $user->cidade;
        if($user->cidade) {
            $user->cidade->estado;
        }
        return response()->json($user);
        
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        //auth('api')->logout();
        //Auth::logout();
        if($request->user()) {
            $request->user()->currentAccessToken()->delete();    
        }
        
        return response()->json(['message' => 'Logout efetuado com sucesso.']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        
        //return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 60
            // 'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function desconectDevice(Request $request)  {
        try {
            
            DB::beginTransaction();
            $params = $request->all();
            DB::table('personal_access_tokens')->where('name', $params['email'])->delete();    
            DB::commit();

            return response()->json([
                'message' => 'Usuário deslogado com sucesso',
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

    }

}