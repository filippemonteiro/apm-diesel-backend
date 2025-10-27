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

// Route::get('/upload', [ImageUploadController::class, 'showUploadForm']);
// Route::post('/upload', [ImageUploadController::class, 'store'])->name('image.upload');

Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::get('/relatorios', 'RelatoriosController@index');    
        
    // Check-in/Check-out (API original)
    Route::post('checkin', 'CheckinController@checkin');
    Route::post('checkout', 'CheckinController@checkout');
    
    // Check-in/Check-out (API compatível com frontend)
    Route::post('frontend/checkin', 'CheckinFrontendController@checkin');
    Route::post('frontend/checkout', 'CheckinFrontendController@checkout');


    Route::get(`carros/qr/{codigo}`, `CarrosController@getCarroBYcode`);
    
    // QR Code
    Route::post('qr-code/vehicle', 'QrCodeController@getVehicle');
    
    // Options
    Route::get('users/options', "UsersController@options");
    Route::post('logout-user', 'AuthController@desconectDevice');
    
    // Crud Rest API
    Route::get('dashboard/totais', "DashboardController@totais");

    // === SISTEMA DE VEÍCULOS ===
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

    // === VEHICLE CHECK-IN/CHECK-OUT SYSTEM ===
    Route::post('vehicles/checkin', 'VehicleCheckinController@checkin');
    Route::post('vehicles/checkout', 'VehicleCheckinController@checkout');
    Route::get('vehicles/checkin-history', 'VehicleCheckinController@checkinHistory');
    Route::get('vehicles/checkout-history', 'VehicleCheckinController@checkoutHistory');

    // === SERVICE REQUESTS SYSTEM ===
    Route::get('service-requests/statistics', 'ServiceRequestController@statistics');
    Route::resource('service-requests', 'ServiceRequestController');

    // CRUD Resources - SISTEMA DE VEÍCULOS
    Route::resource('usuarios', 'UsersController');
    Route::resource('veiculos', 'VeiculosController');
    Route::resource('tipos-servicos', 'TiposServicosController');
    Route::resource('reservas', 'ReservasController');
    Route::resource('servicos', 'ServicosController');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});