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
    
    Route::get('/relatorios', 'RelatoriosController@index');    
    
    Route::get('trajetos/:rota_id', "TrajetosController@listarPorRotas");
    // Options
    Route::get('users/options', "UsersController@options");
    Route::get('cargos/options', 'CargosController@options');
    Route::get('servidores/options', 'ServidoresController@options');
    Route::get('carros/options', 'CarrosController@options');
    Route::get('horarios/options', 'HorariosController@options');
    Route::get('rotas/options', 'RotasController@options');
    Route::get('tipos-chamados/options', 'TiposChamadosController@options');
    
    Route::get('coletas/abertas', 'ColetasController@getListaAbertas');
    Route::post('logout-user', 'AuthController@desconectDevice');
    
    // Crud Rest API
    Route::get('dashboard/totais', "DashboardController@totais");

    // RESOURCES
    Route::resource('horarios-rotas', 'HorariosRotasController');
    Route::resource('tipos-chamados', 'TiposChamadosController');
    Route::resource('chamados', 'ChamadosController');
    Route::resource('atendimentos', 'AtendimentosController');
    Route::resource('coletas', 'ColetasController');
    Route::resource('trajetos', 'TrajetosController');
    Route::resource('estados', 'EstadosController');
    Route::resource('cidades', 'CidadesController');
    Route::resource('users', 'UsersController');
    Route::resource('cargos', 'CargosController');
    Route::resource('servidores', 'ServidoresController');
    Route::resource('horarios', 'HorariosController');
    Route::resource('carros', 'CarrosController');
    Route::resource('rotas', 'RotasController');
    Route::resource('rotas-itens', 'RotasItensController');
    Route::resource('permissoes', 'PermissoesController');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

