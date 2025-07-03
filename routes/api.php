<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return response()->json(['message' => 'Sessão Expirada.']);
})->name('login');


Route::post('login', 'AuthController@login');
Route::post('me', 'AuthController@me');
Route::post('login-app', 'AuthController@loginApp');
Route::post('cadastro', 'UsersController@store');
Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');

Route::post('notificacoes', 'NotificationsController@receiver');
Route::post('notifications', 'NotificationsController@receiver');
Route::get('/relatorios-mobile', 'RelatoriosController@index');    

Route::post('aluno/novo', 'AlunosController@store');
Route::get('estados/options', 'EstadosController@options');
Route::get('cidades/options', 'CidadesController@options');

// Route::get('/upload', [ImageUploadController::class, 'showUploadForm']);
// Route::post('/upload', [ImageUploadController::class, 'store'])->name('image.upload');

Route::group(['middleware' => ['auth:sanctum']], function () {
    
// Options para dropdowns/selects
Route::get('veiculos/options', 'VeiculosController@options');
Route::get('tipos-servicos/options', 'TiposServicosController@options');

// Rotas específicas para Reservas
Route::get('reservas/motorista/{motoristaId}', 'ReservasController@porMotorista');
Route::get('reservas/veiculo/{veiculoId}', 'ReservasController@porVeiculo');

// Rotas específicas para Serviços
Route::get('servicos/tipo/{tipo}', 'ServicosController@porTipo');
Route::get('servicos/motorista/{motoristaId}', 'ServicosController@porMotorista');
Route::get('servicos/veiculo/{veiculoId}', 'ServicosController@porVeiculo');

// CRUD Resources
Route::resource('veiculos', 'VeiculosController');
Route::resource('tipos-servicos', 'TiposServicosController');
Route::resource('reservas', 'ReservasController');
Route::resource('servicos', 'ServicosController');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

